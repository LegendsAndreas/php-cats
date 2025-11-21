<?php

namespace App\Controller;

use Cake\Cache\Cache;
use Cake\Http\Cookie\Cookie;
use Cake\Http\Cookie\CookieCollection;
use Cake\Http\Response;
use Cake\I18n\FrozenTime;
use Cake\Mailer\Email;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;
use JetBrains\PhpStorm\NoReturn;
use Cake\ORM\Exception\PersistenceFailedException;
use Cake\Log\Log;
use \Cake\Error;

/**
 * @property \App\Model\Table\CatsTable            $Cats
 * @property \App\Model\Table\ContributorsTable    $Contributors
 * @property \App\Model\Table\CatContributorsTable $CatContributors
 */
class CatsController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->Contributors    = $this->fetchTable('Contributors');
        $this->CatContributors = $this->fetchTable('CatContributors');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->addUnauthenticatedActions(['index', 'view', 'help']);
    }

    public function view($id): void
    {
        $cat = $this->Cats->get($id); // Fetch the cat by ID

        $this->set('cat', $cat);
    }

    public function help(): Response
    {
        if ($this->request->is('post')) {
            /*            $mailer = new Mailer();
                        $mailer->setTransport('default'); // Explicitly use 'default' transport from your configuration
                        $mailer->setFrom(['andreas2x2@gmail.com' => 'CakePHP Email'])
                               ->setTo('andreas2x2@gmail.com')
                               ->setSubject('Testing Explicit Transport')
                               ->deliver('This is a test email.');*/ //            mail.protonmail.ch
            /*            $data = $this->request->getData();

                        // Extract the form data
                        $title = $data['email_title'] ?? 'No Title';
                        $description = $data['email_description'] ?? 'No Description';
                        $pictures = $data['email_pictures'] ?? [];

                        // Set up the email
                        $mailer = new Mailer('default');
                        $mailer->setTo('andreasbxb@pm.me') // Recipient
                               ->setSubject($title)
                               ->deliver($description); // Email content


                        // Handle attachments
                        if (!empty($pictures)) {
                            foreach ($pictures['tmp_name'] as $index => $tmpName) {
                                if (is_uploaded_file($tmpName)) {
                                    $mailer->addAttachments([
                                        $pictures['name'][$index] => $tmpName,
                                    ]);
                                }
                            }
                        }

                        // Send email
                        if ($mailer->send()) {
                            $this->Flash->success('Your email has been sent successfully!');
                        } else {
                            $this->Flash->error('There was a problem sending your email.');
                        }

                        // Redirect back
                        return $this->render();*/
        }

        return $this->render();
    }

    public function index(): void
    {
        $this->loadComponent('Paginator');

        $query = $this->Cats->find('all')->where(['deleted IS' => null]);

        if ($this->request->getQuery('reverseOrder') === 'true') {
            $query->orderDesc('created');
        } else {
            $query->orderAsc('created');
        }

        $catName = $this->request->getQuery('catName', '');
        if (empty($catName)) {
            $cats = $this->Paginator->paginate($query, ['limit' => 12]);
        } else {
            $catName = $this->formatCatName($catName);

            $cats = $this->Paginator->paginate($query->where(['function_name LIKE' => '%' . $catName . '%']), ['limit' => 12]);
        }
        $this->set(compact('cats'));
    }

    // To make sure that it also looks after special characters, we add a backslash to escape them
    private function formatCatName(string $catName): string
    {
        return str_replace(['%', '_'], ['\\%', '\\_'], $catName);
    }

    // Right now, it automatically creates the contributors and sets the cat contributors relations
    public function add(): ?Response
    {
        $cat = $this->Cats->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $data['contributors'] = $this->getContributorsIdsAndAddMissingEntities($data['contributors']);

            $existingCat = $this->Cats->findByFunctionName($data['function_name'])->first();
            if ($existingCat) {
                $this->Flash->error(__('A cat with the same name already exists.'));

                return $this->redirect(['action' => 'add']);
            }

            $cat = $this->Cats->newEntity($data);

            if ($this->Cats->save($cat)) {
                $this->Flash->success(__('New cat added.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Unable to add the cat :(.'));
            }
        }

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

    public function edit($id): Response
    {
        $cat            = $this->Cats->findById($id)->firstOrFail();
        $contributorIds = $this->CatContributors->find()->where(['cat_id' => $id])->select(['contributor_id'])->extract('contributor_id')->toList();

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

            $this->Cats->patchEntity($cat, $data);

            if ($this->Cats->save($cat)) {
                $this->Flash->success(__('Cat got updated.'));

                return $this->redirect(['action' => 'edit', $id]);
            } else {
                $this->Flash->error(__('Unable to update your article.'));
            }
        }

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
        date_default_timezone_set('Europe/Copenhagen');
        $this->request->allowMethod(['post', 'delete']);

        $page = $this->request->getQuery('page');

        $cat = $this->Cats->findById($id)->firstOrFail();
        $this->Cats->patchEntity($cat, ['deleted' => new FrozenTime(date('d-m-Y H:i:s'))]);

        if ($this->Cats->save($cat)) {
            $this->Flash->success(__('The "{0}" article has been archived as deleted.', $cat->function_name));

            return $this->redirect(['action' => 'index', '?' => ['page' => $page]]);
        } else {
            $this->Flash->error(__('The "{0}" article could not be archived as deleted. Please, try again.', $cat->function_name));

            return $this->redirect(['action' => 'index', '?' => ['page' => $page]]);
        }
    }

    public function fullDelete($id): Response
    {
        $cat = $this->Cats->findById($id)->firstOrFail();
        if ($this->Cats->delete($cat)) {
            $this->Flash->success(__('The "{0}" article has been deleted fully.', $cat->function_name));
        } else {
            $this->Flash->error(__('The "{0}" article could not be deleted fully. Please, try again.', $cat->function_name));
        }

        return $this->redirect(['action' => 'deleted']);
    }

    public function deleted(): void
    {
        $this->loadComponent('Paginator');
        $cats = $this->Cats->find('all')->where(['deleted IS NOT' => null]);
        $this->set(compact('cats'));
    }

    public function restore($id): Response
    {
        $cat = $this->Cats->findById($id)->firstOrFail();
        $this->Cats->patchEntity($cat, ['deleted' => null]);

        if ($this->Cats->save($cat)) {
            $this->Flash->success(__('The "{0}" article has been restored.', $cat->function_name));
        } else {
            $this->Flash->error(__('The "{0}" article could not be restored. Please, try again.', $cat->function_name));
        }

        return $this->redirect(['action' => 'deleted']);
    }

}
