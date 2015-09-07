<?php

use yii\db\Schema;
use yii\db\Migration;

class m150119_063110_party_contact extends Migration
{
    public function up()
    {
        $this->createTable('party_contact', [
                'id' => Schema::TYPE_PK,
                'party_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'name' => Schema::TYPE_STRING . ' NOT NULL',
                'organization' => Schema::TYPE_STRING . ' NOT NULL',
                'email' => Schema::TYPE_STRING . ' NOT NULL',
                'phone' => Schema::TYPE_STRING . ' NOT NULL',
            ]);
    }

    public function down()
    {
        $this->dropTable('party_contact');
        return true;
    }
}
