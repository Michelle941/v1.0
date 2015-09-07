<?php

use yii\db\Schema;
use yii\db\Migration;

class m150118_102149_ticket extends Migration
{
    public function up()
    {
        $this->createTable('ticket', [
            'id' => Schema::TYPE_PK,
            'party_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'bought_at' => Schema::TYPE_INTEGER. ' NOT NULL',
            'price'   => Schema::TYPE_MONEY . ' NOT NULL',
            'hash'  => Schema::TYPE_STRING.' NOT NULL'
        ]);
    }
    public function down()
    {
        $this->dropTable('ticket');
        return true;
    }
}
