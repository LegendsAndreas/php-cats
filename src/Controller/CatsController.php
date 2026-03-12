<?php

namespace App\Controller;

use App\Model\Table\CatContributorsTable;
use App\Model\Table\CatsTable;
use App\Model\Table\ContributorsTable;
use Authentication\Controller\Component\AuthenticationComponent;
use Authorization\Controller\Component\AuthorizationComponent;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\Log\Log;

/**
 * @property CatsTable               $Cats
 * @property ContributorsTable       $Contributors
 * @property CatContributorsTable    $CatContributors
 * @property AuthenticationComponent $Authentication
 * @property AuthorizationComponent  $Authorization
 */
class CatsController extends AppController
{
    private bool $cacheEnabled;
    private \Cake\ORM\Table|\App\Model\Table\CatContributorsTable $CatContributors;
    private \Cake\ORM\Table|\App\Model\Table\ContributorsTable $Contributors;

    public function initialize(): void
    {
        parent::initialize();
        $this->Contributors    = $this->fetchTable('Contributors');
        $this->CatContributors = $this->fetchTable('CatContributors');
        $this->cacheEnabled    = Configure::read('App.EnableCustomCaching');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);

        $this->Authentication->addUnauthenticatedActions(['help']);
    }

    public function view($id): void
    {
        $this->Authorization->skipAuthorization();
        $cacheKey = 'cat_' . $id;
        $cat      = $this->cacheEnabled ? Cache::read($cacheKey, 'cats_view') : null;

        if ($cat === null) {
            $cat = $this->Cats->find()->where(['id' => $id])->contain(['HtmlBlocks', 'Contributors'])->firstOrFail();
            Cache::write($cacheKey, $cat, 'cats_view');
        }

        $this->set('title', 'PHP Cats | View Cat - ' . $cat->function_name);
        $this->set('cat', $cat);
    }

    public function help(): Response
    {
        $this->Authorization->skipAuthorization();
        $this->set('title', 'PHP Cats | Help');

        return $this->render();
    }

    public function index(): Response
    {
        $this->Authorization->skipAuthorization();
        // Build cache key based on query parameters
        $reverseOrder = $this->request->getQuery('reverseOrder', 'false');
        $catName      = $this->request->getQuery('catName', '');
        $page         = $this->request->getQuery('page', '1');
        $cacheKey     = sprintf('cats_index_%s_%s_%s', $reverseOrder, md5($catName), $page);

        $this->response = $this->response->withEtag($cacheKey);

        if ($this->response->isNotModified($this->request)) {
            return $this->response;
        }

        $cached = $this->cacheEnabled ? Cache::read($cacheKey, 'cats_index') : null;

        // If we just use Cache::write($cacheKey, $cats), it will not work, because the meta data for pagination will not be saved.
        if (!is_array($cached) || !isset($cached['cats']) || !isset($cached['paging'])) {
            $query = $this->Cats->find('all')->where(['deleted IS' => null]);

            if ($reverseOrder === 'true') {
                $query->orderByDesc('created');
            } else {
                $query->orderByAsc('created');
            }

            if (!empty($catName)) {
                $catName = $this->formatCatName($catName);
                $query->where(['function_name LIKE' => '%' . $catName . '%']);
            }

            $cats = $this->paginate($query, ['limit' => 12]);

            // Cache both the results and pagination params
            $cached = [
                'cats'   => $cats,
                'paging' => $this->request->getAttribute('paging'),
            ];

            Cache::write($cacheKey, $cached, 'cats_index');
        } else {
            // Cache hit - restore pagination params
            $this->request = $this->request->withAttribute('paging', $cached['paging']);
        }

        // Always pass cats from cached array (whether just cached or previously cached)
        $this->set('title', 'PHP Cats');
        $this->set('cats', $cached['cats']);

        return $this->render();
    }

    // To make sure that it also looks after special characters, we add a backslash to escape them
    private function formatCatName(string $catName): string
    {
        return str_replace(['%', '_'], ['\\%', '\\_'], $catName);
    }

    // Right now, it automatically creates the contributors and sets the cat contributors relations
    public function add(): Response
    {
        $cat = $this->Cats->newEmptyEntity();

        try {
            $this->Authorization->authorize($cat);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('You are not authorized to add cats.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $data['contributors'] = $this->getContributorsIdsAndAddMissingEntities($data['contributors']);

            $existingCat = $this->Cats->findByFunctionName($data['function_name'])->first();
            if ($existingCat) {
                $this->Flash->error(__('A cat with the same name already exists.'));

                return $this->redirect(['action' => 'add']);
            }

            $counter = 0;
            foreach ($data['html_blocks'] as &$htmlBlock) {
                $htmlBlock['sort_order'] = $counter++;
            }

            $cat = $this->Cats->newEntity($data, [
                'associated' => ['HtmlBlocks', 'Contributors'],
            ]);

            if ($this->Cats->save($cat, ['associated' => ['HtmlBlocks', 'Contributors']])) {
                $this->Flash->success(__('New cat added.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Unable to add the cat :(.'));
                Log::error('Failed to save cat: ' . json_encode($cat->getErrors()));
            }
        }

        $this->set('title', 'PHP Cats | Add new cat');
        $this->set(compact('cat'));

        return $this->render();
    }

    /**
     * @param array $contributors
     *
     * Because CakePHP automatically creates the relations if given the IDs, we get the IDs of the existing contributors, or create them if they don't exist.
     * After creating them, the new contributor IDs are returned. Remember to keep the contributor arrays name, "contributors", in plural.
     *
     * @return array
     */
    private function getContributorsIdsAndAddMissingEntities(array $contributors): array
    {
        $normalizedContributors = [];
        foreach ($contributors as $contributor) {
            $existing = $this->Contributors->findByName($contributor['name'])->first();
            if ($existing) {
                $normalizedContributors[] = ['id' => $existing->id];
            } else {
                $newContributor = $this->Contributors->newEntity($contributor);
                if ($this->Contributors->save($newContributor)) {
                    $normalizedContributors[] = ['id' => $newContributor->id];
                } else {
                    $this->Flash->error(__('Unable to add the contributor :(: ' . $contributor['name']));
                }
            }
        }

        return $normalizedContributors;
    }

    public function edit(int $id): Response
    {
        $cat = $this->Cats->findById($id)->contain(['HtmlBlocks'])->firstOrFail();

        try {
            $this->Authorization->authorize($cat);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('You are not authorized to edit cats.'));
            return $this->redirect(['action' => 'index']);
        }

        // We want an array of ids and not of entities.
        $contributorIds = $this->CatContributors->find()->where(['cat_id' => $id])->all()->extract('contributor_id')->toArray();

        if (empty($contributorIds)) {
            $contributors = [];
        } else {
            $contributors = $this->Contributors->find()->where(['id IN' => $contributorIds, 'deleted IS' => null])->toArray();
        }

        if ($this->request->is(['put'])) {
            $data = $this->request->getData();
            if (!isset($data['contributors'])) {
                $data['contributors'] = [];
            }

            $ids = $this->getContributorsIds($data['contributors']);
            if (!empty($ids['notFound'])) {
                $this->Flash->error(__('The following contributors do not exist: ' . implode(', ', $ids['notFound'])));

                return $this->redirect(['action' => 'edit', $id]);
            }
            $data['contributors'] = $ids['found'];

            // Track existing HTML block IDs
            $existingHtmlBlockIds = [];
            foreach ($cat->html_blocks as $block) {
                $existingHtmlBlockIds[] = $block->id;
            }

            // Track HTML block IDs that are in the new data
            $submittedHtmlBlockIds = [];
            $counter               = 0;
            foreach ($data['html_blocks'] as &$htmlBlock) {
                $htmlBlock['sort_order'] = $counter++;
                if (isset($htmlBlock['id'])) {
                    $submittedHtmlBlockIds[] = $htmlBlock['id'];
                }
            }

            // Find HTML blocks to delete (existing but not in submitted data)
            $htmlBlockIdsToDelete = array_diff($existingHtmlBlockIds, $submittedHtmlBlockIds);

            $this->Cats->patchEntity($cat, $data, [
                'associated' => ['HtmlBlocks', 'Contributors'],
            ]);

            if ($this->Cats->save($cat, ['associated' => ['HtmlBlocks', 'Contributors']])) {
                // Delete removed HTML blocks
                if (!empty($htmlBlockIdsToDelete)) {
                    $HtmlBlocks = $this->fetchTable('HtmlBlocks');
                    foreach ($htmlBlockIdsToDelete as $blockId) {
                        $block = $HtmlBlocks->get($blockId);
                        $HtmlBlocks->delete($block);
                    }
                }

                $this->Flash->success(__('Cat got updated.'));

                return $this->redirect(['action' => 'edit', $id]);
            } else {
                $this->Flash->error(__('Unable to update your article.'));
            }
        }

        $this->set('title', 'PHP Cats | Edit Cat - ' . $cat->function_name);
        $this->set(compact('cat', 'contributors'));

        return $this->render();
    }

    private function getContributorsIds(array $contributors): array
    {
        $normalizedContributors = [
            'found'    => [],
            'notFound' => [],
        ];
        foreach ($contributors as $contributor) {
            $existing = $this->Contributors->findByName($contributor['name'])->first();
            if ($existing) {
                $normalizedContributors['found'][] = ['id' => $existing->id];
            } else {
                $normalizedContributors['notFound'][] = $contributor['name'];
            }
        }

        return $normalizedContributors;
    }

    public function delete($id): Response
    {
        $this->request->allowMethod(['post', 'delete']);

        $cat = $this->Cats->findById($id)->firstOrFail();
        try {
            $this->Authorization->authorize($cat);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('You are not authorized to delete cats.'));

            return $this->redirect(['action' => 'index']);
        }

        date_default_timezone_set('Europe/Copenhagen');
        $page = $this->request->getQuery('page');

        $this->Cats->patchEntity($cat, ['deleted' => new \Cake\I18n\DateTime(date('d-m-Y H:i:s'))]);

        if ($this->Cats->save($cat)) {
            $this->clearCacheGroup([
                'cats_index'   => 'cats-index',
                'cats_deleted' => 'cats-deleted',
            ]);
            $this->deleteCacheKey(['cat_' . $id]);

            $this->Flash->success(__('The "{0}" article has been archived as deleted.', $cat->function_name));
        } else {
            $this->Flash->error(__('The "{0}" article could not be archived as deleted. Please, try again.', $cat->function_name));
        }

        return $this->redirect(['action' => 'index', '?' => ['page' => $page]]);
    }

    public function fullDelete($id): Response
    {
        $cat = $this->Cats->findById($id)->firstOrFail();
        try {
            $this->Authorization->authorize($cat);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('You are not authorized to full delete cats.'));

            return $this->redirect(['action' => 'deleted']);
        }

        if ($this->Cats->delete($cat)) {
            $this->clearCacheGroup([
                'cats_deleted' => 'cats-deleted',
            ]);

            $this->Flash->success(__('The "{0}" article has been deleted fully.', $cat->function_name));
        } else {
            $this->Flash->error(__('The "{0}" article could not be deleted fully. Please, try again.', $cat->function_name));
        }

        return $this->redirect(['action' => 'deleted']);
    }

    public function deleted(): void
    {
        $this->Authorization->skipAuthorization();
        $cats = $this->cacheEnabled ? Cache::read('cats_deleted_index', 'cats_deleted') : null;

        if ($cats === null) {
            $cats = $this->Cats->find('all')->where(['deleted IS NOT' => null]);
            Cache::write('cats_deleted_index', $cats->toArray(), 'cats_deleted');
        }

        $this->set('title', 'PHP Cats | Deleted Cats');
        $this->set(compact('cats'));
    }

    public function restore($id): Response
    {
        $this->Authorization->skipAuthorization();
        $cat = $this->Cats->findById($id)->firstOrFail();
        $this->Cats->patchEntity($cat, ['deleted' => null]);

        if ($this->Cats->save($cat)) {
            $this->clearCacheGroup([
                'cats_index'   => 'cats-index',
                'cats_deleted' => 'cats-deleted',
            ]);

            $this->Flash->success(__('The "{0}" article has been restored.', $cat->function_name));
        } else {
            $this->Flash->error(__('The "{0}" article could not be restored. Please, try again.', $cat->function_name));
        }

        return $this->redirect(['action' => 'deleted']);
    }

    public function test(): Response
    {
        $this->set('title', 'PHP Cats | Test');

        return $this->render();
    }

    /**
     * @param array $cacheConfigGroup Key value list of cache config and group name.
     *
     * @return void
     */
    private function clearCacheGroup(array $cacheConfigGroup): void
    {
        foreach ($cacheConfigGroup as $config => $group) {
            $result = Cache::clearGroup($group, $config);
            if (!$result) {
                Log::error('Could not clear cache group ' . $group);
            }
        }
    }

    private function deleteCacheKey(array $cacheKeys): void
    {
        foreach ($cacheKeys as $cacheKey) {
            $result = Cache::delete($cacheKey);
            if (!$result) {
                Log::error('Could not delete cache key ' . $cacheKey);
            }
        }
    }
}
