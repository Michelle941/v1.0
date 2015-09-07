<?php

use yii\db\Schema;
use yii\db\Migration;

class m150820_053902_sale_texts extends Migration
{
    public function up()
    {
        $this->addColumn('sale', 'bottom_text', Schema::TYPE_TEXT);
        $this->addColumn('sale', 'bottom_text_8', Schema::TYPE_TEXT);
        $this->addColumn('sale', 'top_text', Schema::TYPE_TEXT);
    }

    public function down()
    {
        echo "m150820_053902_sale_texts cannot be reverted.\n";

        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
