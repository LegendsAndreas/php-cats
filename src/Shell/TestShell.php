<?php

namespace App\Shell;

use Cake\Console\Shell;

class TestShell extends Shell {
    public function main(): void
    {
        echo "Hello, World!\n";
    }

    public function test(): void
    {
        echo "Test method called!\n";
    }
}
