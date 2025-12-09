<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
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

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $this->set('title', 'PHP Cats | Login');
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Cats',
                'action'     => 'index',
            ]);

            return $this->redirect($redirect);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            $this->Authentication->logout();

            return $this->redirect(['controller' => 'Cats', 'action' => 'index']);
        }
    }

    public function edit(int $id)
    {
        $currentUser = $this->Authentication->getIdentity();
        if ($currentUser->get('id') !== $id) {
            $this->Flash->error(__('You can only edit your own profile'));

            return $this->redirect(['controller' => 'Cats', 'action' => 'index']);
        }
        $user = $this->Users->get($id);
        $this->set(compact('user'));

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data            = $this->request->getData();
            $currentPassword = $data['current_password'];
            $repeatPassword  = $data['repeat_password'];
            $newPassword     = $data['new_password'];

            if (!$user->checkPassword($currentPassword)) {
                $this->Flash->error(__('Old password is incorrect'));

                return $this->render();
            }

            if (empty($newPassword)) {
                $this->Flash->error(__('Password is empty'));

                return $this->render();
            }

            if ($newPassword !== $repeatPassword) {
                $this->Flash->error(__('Passwords do not match'));

                return $this->render();
            }

            $data['password'] = $newPassword;

            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->render();
            } else {
                $this->Flash->error(__('The user could not be saved. Please try again.'));
            }
        }

        return $this->render();
    }
}
