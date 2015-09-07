<?php

use yii\db\Schema;
use yii\db\Migration;

class m150704_044111_instagram_token extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'instagram_token', Schema::TYPE_STRING);
    }

    public function down()
    {
        echo "m150704_044111_instagram_token cannot be reverted.\n";

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
