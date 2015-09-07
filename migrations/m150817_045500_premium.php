<?php

use yii\db\Schema;
use yii\db\Migration;

class m150817_045500_premium extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'subscription_type', Schema::TYPE_STRING);
        $this->addColumn('user', 'transaction_id', Schema::TYPE_BIGINT);
    }

    public function down()
    {
        echo "m150817_045500_premium cannot be reverted.\n";

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
