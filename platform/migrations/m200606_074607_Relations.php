<?php

use yii\db\Schema;
use yii\db\Migration;

class m200606_074607_Relations extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->addForeignKey(
            'fk_user_profile_user_id',
            '{{%user_profile}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_user_profile_user_id', '{{%user_profile}}');
    }
}
