<?php

use Phinx\Migration\AbstractMigration;

class Users extends AbstractMigration
{
    public function up()
    {
        $this->execute('
            CREATE TABLE `users` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `role` VARCHAR(50) NOT NULL COLLATE \'utf8mb4_general_ci\',
                `email` VARCHAR(255) NOT NULL COLLATE \'utf8mb4_general_ci\',
                `password` VARCHAR(255) NOT NULL COLLATE \'utf8mb4_general_ci\',
                `created` DATETIME NULL DEFAULT NULL,
                `modified` DATETIME NULL DEFAULT NULL,
                PRIMARY KEY (`id`) USING BTREE
            )
            COLLATE=\'utf8mb4_general_ci\'
            ENGINE=InnoDB
            AUTO_INCREMENT=2
            ');
    }
}
