<?php

use yii\db\Schema;
use yii\db\Migration;

class m150118_104540_statistic extends Migration
{
    public function up()
    {
        $this->createTable('statistic', [
            'id' => Schema::TYPE_PK,
            'type' => Schema::TYPE_SMALLINT, //просмотр фото или просмотр профиля
            'obj_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER. ' NOT NULL',
            'ip' => Schema::TYPE_STRING
        ]);
    }

    public function down()
    {
        $this->dropTable('statistic');
        return true;
    }
}
