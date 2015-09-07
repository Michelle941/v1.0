<?php

use yii\db\Schema;
use yii\db\Migration;

class m150822_223638_ticket extends Migration
{
    public function up()
    {
        $this->addColumn('ticket', 'name', Schema::TYPE_STRING);
        $this->addColumn('ticket', 'lastname', Schema::TYPE_STRING);
        $this->addColumn('ticket', 'email', Schema::TYPE_STRING);
        $this->addColumn('ticket', 'instagram', Schema::TYPE_STRING);
        $this->addColumn('ticket', 'paid_by', Schema::TYPE_INTEGER);
        $this->addColumn('ticket', 'checked', Schema::TYPE_BOOLEAN);
    }

    public function down()
    {
        echo "m150822_223638_ticket cannot be reverted.\n";

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
