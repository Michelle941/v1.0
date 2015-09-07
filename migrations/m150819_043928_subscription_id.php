<?php

use yii\db\Schema;
use yii\db\Migration;

class m150819_043928_subscription_id extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'subscription_id', Schema::TYPE_BIGINT);
    }

    public function down()
    {
        echo "m150819_043928_subscription_id cannot be reverted.\n";

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
