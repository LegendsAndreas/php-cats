<?php
namespace App\Filter;

use MiniAsset\Filter\AssetFilter;

class CssMinFilter extends AssetFilter
{
    public function output($filename, $content): string
    {
        $compressor = new \tubalmartin\CssMin\Minifier();
        return $compressor->run($content);
    }
}
