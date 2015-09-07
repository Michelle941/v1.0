<?php

use yii\db\Schema;
use yii\db\Migration;

class m150831_034622_ticket_number extends Migration
{
    public function up()
    {
        $this->addColumn('ticket', 'ticket_number_seq', Schema::TYPE_STRING);
    }

    public function down()
    {
        echo "m150831_034622_ticket_number cannot be reverted.\n";

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
