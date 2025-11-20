<?php

use Phinx\Migration\AbstractMigration;

class CatsContributors extends AbstractMigration
{
    public function up(): void
    {
        $this->execute('
CREATE TABLE `cat_contributors` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`cat_id` INT(11) NOT NULL,
	`contributor_id` INT(11) NOT NULL,
	`created` TIMESTAMP NULL DEFAULT NULL,
	`modified` TIMESTAMP NULL DEFAULT NULL,
	PRIMARY KEY (`id`) USING BTREE,
	INDEX `cats_id` (`cat_id`) USING BTREE,
	INDEX `contributor_id` (`contributor_id`) USING BTREE
)
COLLATE=\'utf8mb4_general_ci\'
ENGINE=InnoDB
            ');
    }
}
