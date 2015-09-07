<?php

use yii\db\Schema;
use yii\db\Migration;

class m150629_014542_main_image extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'photo5', Schema::TYPE_STRING);
    }

    public function down()
    {
        echo "m150629_014542_main_image cannot be reverted.\n";

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
