<?php

use yii\db\Schema;
use yii\db\Migration;

class m150218_062158_change_notification_task extends Migration
{
    public function up()
    {
        $this->alterColumn('notification_task', 'value', Schema::TYPE_TEXT);
        $this->alterColumn('notification_task', 'dop_value', Schema::TYPE_TEXT);
    }

    public function down()
    {
        echo "m150218_062158_change_notification_task cannot be reverted.\n";

        return false;
    }
}
