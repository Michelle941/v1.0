<?php

use yii\db\Schema;
use yii\db\Migration;

class m150118_105122_sharing_photo extends Migration
{
    public function up()
    {
        $this->createTable('sharing_photo', [
            'id' => Schema::TYPE_PK,
            'type' => Schema::TYPE_SMALLINT, //фото к себе в профиль или свое фото на стр пати
            'obj_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER. ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('sharing_photo');
        return true;
    }
}
