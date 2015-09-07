<?php

use yii\db\Schema;
use yii\db\Migration;

class m150126_063810_change_sale_table extends Migration
{
    public function up()
    {
        $this->dropTable('comments');
        $this->dropColumn('sale', 'ticket_total');
        $this->dropColumn('sale', 'price');
        $this->dropColumn('sale', 'sale_title');
        $this->dropColumn('sale', 'sale_description');

        $this->addColumn('sale',  'thumbnail', Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
        $this->addColumn('sale',  'mini_flyer', Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
        $this->addColumn('sale',  'flyer_top', Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
        $this->addColumn('sale',  'flyer_bottom', Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
        $this->addColumn('sale',  'message_banner', Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
    }

    public function down()
    {
        echo "m150126_063810_change_sale_table cannot be reverted.\n";

        return false;
    }
}
