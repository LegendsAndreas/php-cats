<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * @property \App\Model\Table\CatsTable            $Cats
 * @property \App\Model\Table\ContributorsTable    $Contributors
 * @property \App\Model\Table\CatContributorsTable $CatContributors
 */
class TestController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->addUnauthenticatedActions(['test']);
    }

    public function test(){
        $this->set('title', 'PHP Cats | Test');
        return $this->render();
    }
}
