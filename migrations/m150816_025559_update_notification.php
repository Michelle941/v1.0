<?php

use yii\db\Schema;
use yii\db\Migration;

class m150816_025559_update_notification extends Migration
{
    public function up()
    {
        $this->addColumn('notification_task', 'created_at', Schema::TYPE_INTEGER);
    }

    public function down()
    {
        echo "m150816_025559_update_notification cannot be reverted.\n";

        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
