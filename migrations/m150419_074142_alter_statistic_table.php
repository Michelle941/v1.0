<?php

use yii\db\Schema;
use yii\db\Migration;

class m150419_074142_alter_statistic_table extends Migration
{
    public function up()
    {
        $this->alterColumn('statistic', 'obj_id', Schema::TYPE_STRING);
        $this->alterColumn('likes', 'photo_id', Schema::TYPE_STRING);
    }

    public function down()
    {
        echo "m150419_074142_alter_statistic_table cannot be reverted.\n";

        return false;
    }
}
