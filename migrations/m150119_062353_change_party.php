<?php

use yii\db\Schema;
use yii\db\Migration;

class m150119_062353_change_party extends Migration
{
    public function up()
    {
        $this->addColumn('party', 'url', Schema::TYPE_STRING . ' NOT NULL');
        $this->addColumn('party', 'location', Schema::TYPE_STRING . ' NOT NULL');
        $this->addColumn('party', 'lon', 'double');
        $this->addColumn('party', 'lat', 'double');
        $this->addColumn('party', 'date', Schema::TYPE_DATE . ' NOT NULL');
        $this->addColumn('party', 'finished_at', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->addColumn('party', 'allow2sharing', Schema::TYPE_BOOLEAN.' DEFAULT true');
        $this->addColumn('party', 'allow2add_photo', Schema::TYPE_BOOLEAN.' DEFAULT true');
        $this->addColumn('party', 'highlight', Schema::TYPE_BOOLEAN.' DEFAULT false');
        $this->addColumn('party', 'status', Schema::TYPE_BOOLEAN.' DEFAULT false'); //publish 0-No 1-Yes
    }

    public function down()
    {
        echo "m150119_062353_change_party cannot be reverted.\n";

        return false;
    }
}
