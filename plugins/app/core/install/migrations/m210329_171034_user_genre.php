<?php

use yii\db\Schema;
use yii\db\Migration;

class m210329_171034_user_genre extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%user_genre}}',
            [
                'id'=> $this->primaryKey(11),
                'user_id'=> $this->integer(11)->null()->defaultValue(null),
                'genre_id'=> $this->integer(11)->null()->defaultValue(null),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%user_genre}}');
    }
}
