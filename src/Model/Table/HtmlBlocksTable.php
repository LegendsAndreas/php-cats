<?php
// src/Model/Table/CatsTable.php
namespace App\Model\Table;

use Cake\Event\EventInterface;
use Cake\Log\Log;
use Cake\ORM\Table;

class HtmlBlocksTable extends Table
{
    // The relations will by default be cascaded when deleting a cat, so no need to further configure.
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->belongsTo('Cats', [
            'className'  => 'Cats',
            'foreignKey' => 'cat_id',
            'sort'       => ['cat_id' => 'ASC'],
        ]);
    }

}
