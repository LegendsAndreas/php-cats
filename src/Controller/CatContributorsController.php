<?php

namespace App\Controller;

use Authorization\Controller\Component\AuthorizationComponent;

/**
 * @property \App\Model\Table\CatContributorsTable $catContributorsTable
 * @property AuthorizationComponent                $Authorization
 */
class CatContributorsController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
    }

    public function index(): void
    {
        $this->Authorization->skipAuthorization();
        $contributors = $this->catContributorsTable->find('all')->toArray();
        $this->set(compact('contributors'));
    }
}
