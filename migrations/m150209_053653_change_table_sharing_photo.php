<?php

use yii\db\Schema;
use yii\db\Migration;

class m150209_053653_change_table_sharing_photo extends Migration
{
    public function up()
    {
        $this->addColumn('sharing_photo', 'user_id', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->addColumn('sharing_photo', 'comment', Schema::TYPE_STRING . ' DEFAULT NULL');
        // 0 - фотка с  пати 1 - совя загруженная фотка
        $this->alterColumn('sharing_photo', 'type', Schema::TYPE_SMALLINT. ' NOT NULL DEFAULT 0');
    }

    public function down()
    {
        echo "m150209_053653_change_table_sharing_photo cannot be reverted.\n";

        return false;
    }
}
