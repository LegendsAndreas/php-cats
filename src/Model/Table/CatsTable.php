<?php
// src/Model/Table/CatsTable.php
namespace App\Model\Table;

use Cake\Event\EventInterface;
use Cake\Log\Log;
use Cake\ORM\Table;

class CatsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }

    public function beforeMarshal(EventInterface $event, \ArrayObject $data, \ArrayObject $options): void
    {
        if (isset($data['base64_image'])) {
            if ($this->isBase64($data['base64_image'])) {
                // Nothing, since its already base64
                return;
            } else {
                $data['base64_image'] = $this->getCatImage($data['base64_image']);
            }
        }
    }

    private function getCatImage(string $imageName): ?string
    {
        $path = WWW_ROOT . 'img' . DS . $imageName;
        if (!file_exists($path)) {
            return null;
        }

        return base64_encode(file_get_contents($path));
    }

    /**
     * If the parsed string is a valid base64 string AND when decoded back to base64, it is equal to the parsed string,
     * we return true.
     */
    private function isBase64($string): bool
    {
        $decoded = base64_decode($string, true);
        return $decoded !== false && base64_encode($decoded) === $string;
    }

}
