<?php

use yii\db\Schema;
use yii\db\Migration;

class m150802_213744_party_tags extends Migration
{
    public function up()
    {
        $this->addColumn('party', 'tags', Schema::TYPE_STRING);
    }

    public function down()
    {
        echo "m150802_213744_party_tags cannot be reverted.\n";

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
