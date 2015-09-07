<?php

use yii\db\Schema;
use yii\db\Migration;

class m150118_101848_sale extends Migration
{
    public function up()
    {
        $this->createTable('sale', [
            'id' => Schema::TYPE_PK,
            'party_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'sale_type' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'sale_title' => Schema::TYPE_STRING . ' NOT NULL',
            'sale_description' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER. ' NOT NULL',
            'started_at' => Schema::TYPE_INTEGER. ' NOT NULL',
            'finished_at' => Schema::TYPE_INTEGER. ' NOT NULL',
            'ticket_total' => Schema::TYPE_INTEGER . ' NOT NULL',
            'price'   => Schema::TYPE_MONEY . ' NOT NULL',
        ]);
    }
    public function down()
    {
        $this->dropTable('sale');
        return true;
    }
}
