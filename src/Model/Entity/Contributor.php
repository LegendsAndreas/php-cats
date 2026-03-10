<?php
// src/Model/Entity/Cat.php
namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * @property int        $id
 * @property string     $email
 * @property string     $name
 * @property string     $social
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property Cat[]      $cats
 */
class Contributor extends Entity
{
    protected array $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
