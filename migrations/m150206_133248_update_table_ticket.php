<?php

use yii\db\Schema;
use yii\db\Migration;

class m150206_133248_update_table_ticket extends Migration
{
    public function up()
    {
        $this->addColumn('ticket', 'ticket_type_id', Schema::TYPE_INTEGER . ' NOT NULL');
    }

    public function down()
    {
        echo "m150206_133248_update_table_ticket cannot be reverted.\n";

        return false;
    }
}
