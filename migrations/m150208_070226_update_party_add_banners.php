<?php

use yii\db\Schema;
use yii\db\Migration;

class m150208_070226_update_party_add_banners extends Migration
{
    public function up()
    {
        $this->addColumn('party',  'thumbnail', Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
        $this->addColumn('party',  'mini_flyer', Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
        $this->addColumn('party',  'flyer_top', Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
        $this->addColumn('party',  'flyer_bottom', Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
        $this->addColumn('party',  'message_banner', Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
    }

    public function down()
    {
        echo "m150208_070226_update_party_add_banners cannot be reverted.\n";

        return false;
    }
}
