<?php

use Phinx\Migration\AbstractMigration;

class CreateHtmlBlocks extends AbstractMigration
{
    /**
     * @return void
     */
    public function up()
    {
        $this->execute("
            CREATE TABLE `html_blocks` (
	            `id` INT(11) NOT NULL AUTO_INCREMENT,
                `cat_id` INT(11) NULL DEFAULT '0',
                `order` INT(11) NULL DEFAULT '0',
                `type` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
                `content` TEXT NOT NULL COLLATE 'utf8mb4_general_ci',
                `created` TIMESTAMP NULL DEFAULT NULL,
                `modified` TIMESTAMP NULL DEFAULT NULL,
                PRIMARY KEY (`id`) USING BTREE,
                INDEX `Kolonne 2` (`cat_id`) USING BTREE
            )
            COLLATE='utf8mb4_general_ci'
            ENGINE=InnoDB
            ;
        ");
    }
}
