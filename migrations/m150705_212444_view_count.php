<?php

use yii\db\Schema;
use yii\db\Migration;

class m150705_212444_view_count extends Migration
{
    public function up()
    {
        $this->addColumn('photo', 'view_count', Schema::TYPE_INTEGER);
    }

    public function down()
    {
        echo "m150705_212444_view_count cannot be reverted.\n";

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
