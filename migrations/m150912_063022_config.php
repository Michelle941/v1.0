<?php

use yii\db\Schema;
use yii\db\Migration;

class m150912_063022_config extends Migration
{
    public function up()
    {
        $this->alterColumn('config', 'value', Schema::TYPE_TEXT . ' DEFAULT NULL');
    }

    public function down()
    {
        echo "m150912_063022_config cannot be reverted.\n";

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
