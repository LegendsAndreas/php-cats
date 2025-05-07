<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class CatsComponent extends Component
{
    public function getAlertValues(): string
    {
        return "OK";
//        return TableRegistry::getTableLocator()->get('Cats')->find()->all();
    }
}
