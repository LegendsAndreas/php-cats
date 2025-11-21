<?php
// src/Model/Entity/Cat.php
namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $social
 * @property FrozenTime $created
 * @property FrozenTime $modified
 */

class Contributor extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
