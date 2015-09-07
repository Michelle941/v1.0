<?php

use yii\db\Schema;
use yii\db\Migration;

class m150120_070157_change_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'name', Schema::TYPE_STRING . ' NOT NULL');
        $this->addColumn('user', 'last_name', Schema::TYPE_STRING . ' NOT NULL');
        $this->addColumn('user', 'dob', Schema::TYPE_DATE . ' NOT NULL');
        $this->addColumn('user', 'gender', Schema::TYPE_SMALLINT);
        $this->addColumn('user', 'rank',Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 2');
        $this->addColumn('user', 'relation_status', Schema::TYPE_SMALLINT);
        $this->addColumn('user', 'tag_line', Schema::TYPE_STRING);

        $this->addColumn('user', 'zip_code', Schema::TYPE_STRING . ' NOT NULL');
        $this->addColumn('user', 'city', Schema::TYPE_STRING . ' NOT NULL');
        $this->addColumn('user', 'region', Schema::TYPE_STRING . ' NOT NULL');
        $this->addColumn('user', 'state', Schema::TYPE_STRING . ' NOT NULL');

        $this->addColumn('user', 'premium_status', Schema::TYPE_SMALLINT . ' NOT NULL'); //0-not 1-free 2-paid
        $this->addColumn('user', 'premium_type', Schema::TYPE_SMALLINT);    //monthly / annual
        $this->addColumn('user', 'premium_start_date', Schema::TYPE_INTEGER);
        $this->addColumn('user', 'premium_end_date', Schema::TYPE_INTEGER);

        $this->addColumn('user', 'work', Schema::TYPE_TEXT);
        $this->addColumn('user', 'love', Schema::TYPE_TEXT);

    }

    public function down()
    {
        echo "m150120_070157_change_user cannot be reverted.\n";

        return false;
    }
}
