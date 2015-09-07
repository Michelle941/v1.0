<?php

use yii\db\Schema;
use yii\db\Migration;

class m150815_075323_dob extends Migration
{
    public function up()
    {
        $this->alterColumn('user', 'dob', Schema::TYPE_STRING . ' DEFAULT NULL');
    }

    public function down()
    {
        echo "m150815_075323_dob cannot be reverted.\n";

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
