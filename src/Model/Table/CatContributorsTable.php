<?php
// src/Model/Table/CatsTable.php
namespace App\Model\Table;

use Cake\Event\EventInterface;
use Cake\Log\Log;
use Cake\ORM\Table;

class CatContributorsTable extends Table
{
    // The relations will by default be cascaded when deleting a cat, so no need to further configure.
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }

}
