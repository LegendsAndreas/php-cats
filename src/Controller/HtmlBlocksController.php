<?php

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
 * @property \App\Model\Table\CatsTable       $Cats
 * @property \App\Model\Table\HtmlBlocksTable $HtmlBlocks
 */
class HtmlBlocksController extends AppController
{
    private bool $cacheEnabled;
    public function initialize(): void
    {
        parent::initialize();
        $this->Cats         = $this->fetchTable('Cats');
        $this->cacheEnabled = Configure::read('App.EnableCustomCaching');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->addUnauthenticatedActions(['index', 'view', 'help']);
    }

    public function test()
    {
        $this->loadModel('Cats');
        if ($this->request->is('post')) {
            $catId      = 73;
            $items      = $this->request->getData('items');
            $htmlBlocks = [];
            foreach ($items as $index => $item) {
                $htmlBlocks[] = [
                    'cat_id'  => $catId,
                    'order'   => $index,
                    'content' => $item['content'],
                    'type'    => $item['type'],
                ];
            }
            // Save to database
            $this->HtmlBlocks->saveMany($htmlBlocks);
        }

        $this->set('title', 'PHP Cats | Test');
    }
}
