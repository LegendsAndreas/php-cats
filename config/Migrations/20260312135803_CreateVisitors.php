<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateVisitors extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/5/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function up()
    {
        $this->execute('
CREATE TABLE `visitors` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`country` CHAR(255) NOT NULL COLLATE "utf8mb4_general_ci",
	`count` INT(11) NOT NULL,
	`created` DATETIME NOT NULL,
	`modified` DATETIME NOT NULL,
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE="utf8mb4_general_ci"
ENGINE=InnoDB
;

        ');
    }
}
