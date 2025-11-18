<?php
// src/Model/Table/CatsTable.php
namespace App\Model\Table;

use Cake\Event\EventInterface;
use Cake\Log\Log;
use Cake\ORM\Table;

class CatsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }

}
