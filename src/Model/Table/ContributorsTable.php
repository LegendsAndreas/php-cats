<?php
// src/Model/Table/CatsTable.php
namespace App\Model\Table;

use Cake\Event\EventInterface;
use Cake\Log\Log;
use Cake\ORM\Table;

class ContributorsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Cats', [
            'foreignKey' => 'contributor_id',
            'targetForeignKey' => 'cat_id',
            'joinTable' => 'cat_contributors'
        ]);
    }

}
