<?php

use yii\db\Schema;
use yii\db\Migration;

class m150808_234300_photo_delete extends Migration
{
    public function up()
    {
        $this->addColumn('photo', 'deleted_user', Schema::TYPE_BOOLEAN);
        $this->addColumn('photo', 'deleted_party', Schema::TYPE_BOOLEAN);
    }

    public function down()
    {
        echo "m150808_234300_photo_delete cannot be reverted.\n";

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
