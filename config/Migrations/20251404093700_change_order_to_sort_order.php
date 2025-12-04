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
            ALTER TABLE `html_blocks`
                CHANGE COLUMN `order` `sort_order` INT(11) NULL DEFAULT '0' AFTER `cat_id`;
        ");
    }
}
