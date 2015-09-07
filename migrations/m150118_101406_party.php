<?php

use yii\db\Schema;
use yii\db\Migration;

class m150118_101406_party extends Migration
{
    public function up()
    {
        $this->createTable('party', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'flayer' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER. ' NOT NULL',
            'started_at' => Schema::TYPE_INTEGER. ' NOT NULL',
            'ticket_total' => Schema::TYPE_INTEGER . ' NOT NULL',
            'base_price'   => Schema::TYPE_MONEY . ' NOT NULL',
        ]);
        /*
CONTACT INFORMATION #1
Name:
Organization:
Email:
Phone:
CONTACT INFORMATION #1
Name:
Organization:
Email:
Phone:
        Add one more

Add staff to manage this event (подумать как прикрутить мой модуль прав!)

Attache members profile

Sale option seen in sale migration
*/
    }
    public function down()
    {
        $this->dropTable('party');
        return true;
    }
}
