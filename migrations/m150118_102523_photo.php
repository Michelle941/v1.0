<?php

use yii\db\Schema;
use yii\db\Migration;

class m150118_102523_photo extends Migration
{
    public function up()
    {
        $this->createTable('photo', [
            'id' => Schema::TYPE_PK,
            'load_user_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER. ' NOT NULL',
            'image'   => Schema::TYPE_STRING . ' NOT NULL',
            'allow2sharing' => Schema::TYPE_BOOLEAN.' DEFAULT true',
            'allow2comment' => Schema::TYPE_BOOLEAN.' DEFAULT true'
        ]);
    }
    public function down()
    {
        $this->dropTable('photo');
        return true;
    }
}
