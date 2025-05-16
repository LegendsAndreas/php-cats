<?php

use Phinx\Migration\AbstractMigration;

class Cats extends AbstractMigration
{
    public function up()
    {
        $this->execute('
            CREATE TABLE `cats` (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `function_name` TEXT NOT NULL COLLATE \'utf8mb4_general_ci\',
                `function_description` TEXT NOT NULL COLLATE \'utf8mb4_general_ci\',
                `function_example` TEXT NULL DEFAULT NULL COLLATE \'utf8mb4_general_ci\',
                `base64_image` LONGTEXT NOT NULL COLLATE \'utf8mb4_general_ci\',
                `deleted` DATETIME NULL DEFAULT NULL,
                `created` DATETIME NOT NULL,
                `modified` DATETIME NOT NULL,
                PRIMARY KEY (`id`) USING BTREE
            )
            COLLATE=\'utf8mb4_general_ci\'
            ENGINE=InnoDB
            AUTO_INCREMENT=60
            ');
    }
}
