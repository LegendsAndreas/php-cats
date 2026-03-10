<?php
// src/Model/Entity/Cat.php
namespace App\Model\Entity;

use Cake\I18n\DateTime;
use Cake\ORM\Entity;

/**
 * @property int $id
 * @property int $cat_id
 * @property int $contributor_id
 * @property DateTime $created
 * @property DateTime $modified
 */
class CatContributors extends Entity
{
    protected array $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
