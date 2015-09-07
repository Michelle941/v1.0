<?php

use yii\db\Schema;
use yii\db\Migration;

class m150716_060755_instagram_id extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'instagram_user_id', Schema::TYPE_INTEGER);
    }

    public function down()
    {
        echo "m150716_060755_instagram_id cannot be reverted.\n";

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
