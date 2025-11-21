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
 * @property \App\Model\Table\ContributorsTable $Contributors
 */
class ContributorsController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->addUnauthenticatedActions(['index', 'view', 'help']);
    }

    public function index()
    {
        $contributors   = $this->Contributors->find()->Where(['deleted IS' => null])->contain(['Cats' => function ($cat) {
            return $cat->select(['id', 'function_name'])->Where(['deleted IS' => null]);
        }])->toList();
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

        $this->set(compact('contributors', 'newContributor'));
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

        $this->set(compact('contributor'));
    }

    public function view($id)
    {
        $contributor = $this->Contributors->get($id);
        $this->set(compact('contributor'));
    }
}
