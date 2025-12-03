<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Cache\Cache;
use Cake\Core\Configure;
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
 * @property \App\Model\Table\ContributorsTable $Contributors
 */
class ContributorsController extends AppController
{
    private bool $cacheEnabled;
    public function initialize(): void
    {
        parent::initialize();
        $this->cacheEnabled = Configure::read('App.EnableCustomCaching');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->addUnauthenticatedActions(['index', 'view', 'help']);
    }

    public function index()
    {
        $this->loadComponent('Paginator');

        $newContributor = $this->Contributors->newEmptyEntity();
        if ($this->request->is('post')) {
            if (!$this->Authentication->getIdentity()) {
                $this->Flash->error(__('You must be logged in to add a contributor.'));

                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }
            $data          = $this->request->getData();
            $doesNameExist = $this->Contributors->findByName($data['name'])->first();
            if ($doesNameExist) {
                $this->Flash->error(__('A contributor with the same name already exists.'));

                return $this->redirect(['action' => 'index']);
            }

            $newContributor = $this->Contributors->patchEntity($newContributor, $data);
            if ($this->Contributors->save($newContributor)) {
                $this->Flash->success(__('Contributor added successfully'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Unable to add the contributor :(: ' . $newContributor['name']));
            }
        }

        $contributorName = $this->request->getQuery('name', '');
        $page            = $this->request->getQuery('page', '1');

        $cacheKey = sprintf('contributors_index_%s_%s', $contributorName, $page);
        $cached   = $this->cacheEnabled ? Cache::read($cacheKey, 'contributors_index') : null;

        if ($cached === null) {
            $query = $this->Contributors->find()->Where(['deleted IS' => null])->contain([
                'Cats' => function ($cat) {
                    return $cat->select(['id', 'function_name'])->Where(['deleted IS' => null]);
                },
            ]);

            if (!empty($contributorName)) {
                $contributorName = $this->formatContributorName($contributorName);
                $query->where(['name LIKE' => '%' . $contributorName . '%']);
            }

            $contributors = $this->Paginator->paginate($query, ['limit' => 20]);

            $cached = [
                'contributors' => $contributors,
                'paging'       => $this->request->getAttribute('paging'),
            ];

            Cache::write($cacheKey, $cached, 'contributors_index');
        } else {
            // Cache hit - restore pagination params
            $this->request = $this->request->withAttribute('paging', $cached['paging']);
        }

        $this->set('title', 'PHP Cats | Contributors');
        $this->set('contributors', $cached['contributors']);
        $this->set('newContributor');
    }

    private function formatContributorName(string $catName): string
    {
        return str_replace(['%', '_'], ['\\%', '\\_'], $catName);
    }

    public function delete($id)
    {
        date_default_timezone_set('Europe/Copenhagen');
        $contributor          = $this->Contributors->get($id);
        $contributor->deleted = new FrozenTime(date('d-m-Y H:i:s'));
        if ($this->Contributors->save($contributor)) {
            $this->Flash->success(__('Contributor deleted successfully'));
        } else {
            $this->Flash->error(__('Unable to delete the contributor'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function edit($id)
    {
        $contributor = $this->Contributors->get($id);

        if ($this->request->is(['put'])) {
            $this->Contributors->patchEntity($contributor, $this->request->getData());
            if ($this->Contributors->save($contributor)) {
                $this->Flash->success(__('Contributor updated successfully'));
            } else {
                $this->Flash->error(__('Unable to update the contributor'));
            }
        }

        $this->set('title', 'PHP Cats | Edit Contributor - ' . $contributor->name);
        $this->set(compact('contributor'));
    }

    public function view($id)
    {
        $contributor = $this->Contributors->get($id);
        $this->set('title', 'PHP Cats | View Contributor - ' . $contributor->name);
        $this->set(compact('contributor'));
    }
}
