<?php

use Phinx\Migration\AbstractMigration;

class Contributors extends AbstractMigration
{
    public function up(): void
    {
        $this->execute('
            CREATE TABLE `contributors` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(255) NULL DEFAULT NULL COLLATE \'utf8mb4_general_ci\',
	`name` VARCHAR(255) NULL DEFAULT NULL COLLATE \'utf8mb4_general_ci\',
	`social` VARCHAR(255) NULL DEFAULT NULL COLLATE \'utf8mb4_general_ci\',
	`created` DATETIME NULL DEFAULT NULL,
	`modified` DATETIME NULL DEFAULT NULL,
	`deleted` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE=\'utf8mb4_general_ci\'
ENGINE=InnoDB
            ');
    }
}
