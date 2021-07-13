<?php

use yii\db\Schema;
use yii\db\Migration;

class m210329_171033_user_collection_book extends Migration
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
            '{{%user_collection_book}}',
            [
                'id'=> $this->primaryKey(11),
                'collection_id'=> $this->integer(11)->null()->defaultValue(null),
                'book_id'=> $this->integer(11)->null()->defaultValue(null),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%user_collection_book}}');
    }
}
