<?php

namespace App\Controller;

use JetBrains\PhpStorm\NoReturn;
use Cake\ORM\Exception\PersistenceFailedException;
use Cake\Log\Log;
use \Cake\Error;

/**
 * @property \App\Model\Table\CatsTable $Cats
 */
class CatsController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        // Remove 'index' from unauthenticated actions for this specific controller
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }

    public function view($id): void
    {
        $cat = $this->Cats->get($id); // Fetch the cat by ID
        $this->set(compact('cat'));
    }

    public function index(): void
    {
        $this->loadComponent('Paginator');
        $cats = $this->Paginator->paginate($this->Cats->find('all'), ['limit' => 12]);
        $this->set(compact('cats'));
    }

    public function add(): ?\Cake\Http\Response
    {
        $cat = $this->Cats->newEmptyEntity();
        if ($this->request->is('post')) {
            $existingCat = $this->Cats->findByFunctionName($this->request->getData('function_name'))->first();
            if ($existingCat) {
                $this->Flash->error(__('A cat with the same name already exists.'));
                return $this->redirect(['action' => 'add']);
            }

            $cat = $this->Cats->newEntity($this->request->getData());

            if (!$cat->base64_image) {
                $this->Flash->error(__('Cat image not found.'));
            } elseif ($this->Cats->save($cat)) {
                $this->Flash->success(__('New cat added.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Unable to add the cat :(.'));
            }
        }

        $this->set('cat', $cat);
        return $this->render();
    }

    public function edit($id): ?\Cake\Http\Response
    {
        $cat = $this->Cats
            ->findById($id)
            ->firstOrFail();

        if ($this->request->is(['put'])) {
            $this->Cats->patchEntity($cat, $this->request->getData());

            if (!$cat->base64_image) {
                $this->Flash->error(__('Cat image not found.'));
            } elseif ($this->Cats->save($cat)) {
                $this->Flash->success(__('Cat got updated.'));
                return $this->redirect(['action' => 'edit', $id]);
            } else {
                $this->Flash->error(__('Unable to update your article.'));
            }
        }

        $this->set('cat', $cat);
        return $this->render();
    }

    public function delete($id): ?\Cake\Http\Response
    {
        $this->request->allowMethod(['post', 'delete']);

        $cat = $this->Cats->findById($id)->firstOrFail();
        if ($this->Cats->delete($cat)) {
            $this->Flash->success(__('The "{0}" article has been deleted.', $cat->function_name));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('The "{0}" article could not be deleted. Please, try again.', $cat->function_name));
        }

        return $this->render();
    }
}
