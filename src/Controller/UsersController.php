<?php
declare(strict_types=1);

namespace App\Controller;

use Authentication\Controller\Component\AuthenticationComponent;
use Authorization\Controller\Component\AuthorizationComponent;
use Cake\Http\Response;

/**
 * Users Controller
 *
 * @property AuthenticationComponent     $Authentication
 * @property AuthorizationComponent      $Authorization
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login']);
    }

    public function login(): Response
    {
        $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['get', 'post']);
        $this->set('title', 'PHP Cats | Login');
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            return $this->redirect(['controller' => 'Cats', 'action' => 'index']);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }

        return $this->render();
    }

    public function logout(): Response
    {
        $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            $this->Authentication->logout();

            return $this->redirect(['controller' => 'Cats', 'action' => 'index']);
        }

        $this->Flash->error(__('Authentication problem logging out. Please try again.'));
        return $this->redirect(['controller' => 'Cats', 'action' => 'index']);
    }
}
