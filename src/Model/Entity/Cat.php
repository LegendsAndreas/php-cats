<?php
// src/Model/Entity/Cat.php
namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * @property int $id
 * @property string $function_name
 * @property string $function_description
 * @property string $function_example
 * @property string $base64_image
 * @property FrozenTime $created
 * @property FrozenTime $modified
 */

class Cat extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
