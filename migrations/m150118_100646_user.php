<?php

use yii\db\Schema;
use yii\db\Migration;

class m150118_100646_user extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'auth_key' => Schema::TYPE_STRING . ' NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING . ' NOT NULL',
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER. ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER. ' NOT NULL', //last login
        ]);
    }
    /*
load 5 photo in profile + up to 4 for premium

     */
    public function down()
    {
        $this->dropTable('user');
        return true;
    }
}
