<?php
// src/Model/Entity/Cat.php
namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * @property int        $id
 * @property int        $cat_id
 * @property int        $sort_order
 * @property string     $type
 * @property bool       $escape_html
 * @property string     $content
 * @property FrozenTime $created
 * @property FrozenTime $modified
 */
class HtmlBlock extends Entity
{
    protected $_accessible = [
        '*'  => true,
        'id' => false,
    ];
}
