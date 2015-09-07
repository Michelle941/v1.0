<?php

use yii\db\Schema;
use yii\db\Migration;

class m150120_181704_change_user_dafault extends Migration
{
    public function up()
    {
        $this->dropColumn('user', 'username');
        $this->alterColumn('user', 'auth_key',  Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
        $this->alterColumn('user', 'password_hash',  Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
        $this->alterColumn('user', 'name',  Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
        $this->alterColumn('user', 'last_name',  Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
        $this->alterColumn('user', 'dob',  Schema::TYPE_DATE . ' DEFAULT NULL');
        $this->alterColumn('user', 'zip_code',  Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
        $this->alterColumn('user', 'city',  Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
        $this->alterColumn('user', 'region',  Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
        $this->alterColumn('user', 'state',  Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
        $this->alterColumn('user', 'premium_status', Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0');
    }

    public function down()
    {
        echo "m150120_181704_change_user_dafault cannot be reverted.\n";

        return false;
    }
}
