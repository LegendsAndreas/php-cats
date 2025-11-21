<?php
// src/Model/Entity/Cat.php
namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * @property int $id
 * @property int $cat_id
 * @property int $contributor_id
 * @property FrozenTime $created
 * @property FrozenTime $modified
 */

class CatContributors extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
