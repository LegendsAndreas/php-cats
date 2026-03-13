<?php
// src/Model/Table/CatsTable.php
namespace App\Model\Table;

use Cake\Cache\Cache;
use Cake\ORM\Table;

class CatsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Contributors', [
            'foreignKey'       => 'cat_id',
            'targetForeignKey' => 'contributor_id',
            'joinTable'        => 'cat_contributors',
        ]);
        $this->hasMany('HtmlBlocks', [
            'foreignKey' => 'cat_id',
            'dependent'  => true,
        ]);
    }

    public function afterSaveCommit(): void
    {
        Cache::clear('sitemap');
    }

    public function afterDeleteCommit(): void
    {
        Cache::clear('sitemap');
    }
}
