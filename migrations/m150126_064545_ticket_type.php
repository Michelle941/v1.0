<?php

use yii\db\Schema;
use yii\db\Migration;

class m150126_064545_ticket_type extends Migration
{
    public function up()
    {
        $this->createTable('ticket_type', [
                'id' => Schema::TYPE_PK,
                'sale_id' => Schema::TYPE_INTEGER.' NOT NULL',
                'title' => Schema::TYPE_STRING . ' NOT NULL',
                'description' => Schema::TYPE_TEXT . ' NOT NULL',
                'quantity' => Schema::TYPE_INTEGER . ' NOT NULL',
                'price'   => Schema::TYPE_MONEY . ' NOT NULL',
                'image'   => Schema::TYPE_STRING . ' NOT NULL',
                'created_at' => Schema::TYPE_INTEGER. ' NOT NULL'
            ]);
    }

    public function down()
    {
        $this->dropTable('ticket_type');
        return true;
    }
}
