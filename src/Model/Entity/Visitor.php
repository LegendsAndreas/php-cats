<?php
// src/Model/Entity/Cat.php
namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * @property int                 $id
 * @property string              $country
 * @property int                 $count
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 */
class Visitor extends Entity
{
    protected array $_accessible = [
        '*'  => true,
        'id' => false,
    ];
}
