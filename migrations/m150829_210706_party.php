<?php

use yii\db\Schema;
use yii\db\Migration;

class m150829_210706_party extends Migration
{
    public function up()
    {
        $this->addColumn('party', 'username', Schema::TYPE_STRING);
        $this->addColumn('party', 'password', Schema::TYPE_STRING);
        $this->addColumn('party', 'ticket_prefix', Schema::TYPE_STRING);
        $this->addColumn('ticket', 'ticket_number', Schema::TYPE_STRING);
    }

    public function down()
    {
        echo "m150829_210706_party cannot be reverted.\n";

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
