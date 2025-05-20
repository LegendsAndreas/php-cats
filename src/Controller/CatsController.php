<?php

namespace App\Controller;

use Cake\Http\Cookie\Cookie;
use Cake\Http\Cookie\CookieCollection;
use Cake\Http\Response;
use Cake\I18n\FrozenTime;
use JetBrains\PhpStorm\NoReturn;
use Cake\ORM\Exception\PersistenceFailedException;
use Cake\Log\Log;
use \Cake\Error;

/**
 * @property \App\Model\Table\CatsTable $Cats
 */
class CatsController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }

    public function view($id): void
    {
        $cat = $this->Cats->get($id); // Fetch the cat by ID
        $this->set(compact('cat'));
    }

    public function index(string $catName = null): void
    {
        $this->loadComponent('Paginator');

        $query = $this->Cats->find('all')->where(['deleted IS' => null]);
//        $this->setCookie();

        if ($this->request->getQuery('reverseOrder') === 'true') {
            $query->orderDesc('created');
        } else {
            $query->orderAsc('created');
        }


        if (empty($catName)) {
            $cats = $this->Paginator->paginate($query, ['limit' => 12]);
        } else {
            $catName = $this->formatCatName($catName);

            $cats = $this->Paginator->paginate(
                $query
                    ->where(['function_name LIKE' => '%' . $catName . '%']),
                ['limit' => 12],
            );
        }
        $this->set(compact('cats'));
    }

    // To make sure that it also looks after special characters, we add a backslash to escape them
    private function formatCatName(string $catName): string
    {
        return str_replace(['%', '_'], ['\\%', '\\_'], $catName);
    }

/*    private function setCookie()
    {
        // Create a cookie collection
        $cookies = new CookieCollection();

        // Create multiple cookies
        $cookie1 = (new Cookie('php-cookie'))
            ->withValue('true')
            ->withExpiry(new \DateTime('+1 year'))
            ->withPath('/')
            ->withHttpOnly(true)
            ->withSecure(false);

        $cookie2 = (new Cookie('another-cookie'))
            ->withValue('false')
            ->withExpiry(new \DateTime('+1 month'))
            ->withPath('/')
            ->withHttpOnly(true)
            ->withSecure(false);

        // Add cookies to the cookie collection
        $cookies = $cookies->add($cookie1)->add($cookie2);

        // Attach all cookies from the collection to the response object
        foreach ($cookies as $currentCookie) {
            $this->response = $this->response->withCookie($currentCookie);
        }

    }*/


    public function add(): ?Response
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

    public function edit($id): Response
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

    public function delete($id): Response
    {
        date_default_timezone_set('Europe/Copenhagen');
        $this->request->allowMethod(['post', 'delete']);

        $cat = $this->Cats->findById($id)->firstOrFail();
        $this->Cats->patchEntity(
            $cat,
            ['deleted' => new FrozenTime(date('d-m-Y H:i:s'))],
        );

        if ($this->Cats->save($cat)) {
            $this->Flash->success(__('The "{0}" article has been archived as deleted.', $cat->function_name));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(
                __('The "{0}" article could not be archived as deleted. Please, try again.', $cat->function_name),
            );
            return $this->redirect(['action' => 'index']);
        }
    }

    public function deleted(): void
    {
        $this->loadComponent('Paginator');
        $cats = $this->Cats->find('all')->where(['deleted IS NOT' => null]);
        $this->set(compact('cats'));
    }

    public function restore($id)
    {
        $cat = $this->Cats->findById($id)->firstOrFail();
        $this->Cats->patchEntity(
            $cat,
            ['deleted' => null],
        );

        if ($this->Cats->save($cat)) {
            $this->Flash->success(__('The "{0}" article has been restored.', $cat->function_name));
        } else {
            $this->Flash->error(__('The "{0}" article could not be restored. Please, try again.', $cat->function_name));
        }
        return $this->redirect(['action' => 'index']);
    }
}
