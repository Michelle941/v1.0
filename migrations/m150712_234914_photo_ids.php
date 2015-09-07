<?php

use yii\db\Schema;
use yii\db\Migration;

class m150712_234914_photo_ids extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'avatar_id', Schema::TYPE_INTEGER);
        $this->addColumn('user', 'photo1_id', Schema::TYPE_INTEGER);
        $this->addColumn('user', 'photo2_id', Schema::TYPE_INTEGER);
        $this->addColumn('user', 'photo3_id', Schema::TYPE_INTEGER);
        $this->addColumn('user', 'photo4_id', Schema::TYPE_INTEGER);
        $this->addColumn('user', 'photo5_id', Schema::TYPE_INTEGER);
    }

    public function down()
    {
        echo "m150712_234914_photo_ids cannot be reverted.\n";

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
