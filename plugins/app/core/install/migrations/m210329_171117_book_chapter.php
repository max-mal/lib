<?php

use yii\db\Schema;
use yii\db\Migration;

class m210329_171117_book_chapter extends Migration
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
            '{{%book_chapter}}',
            [
                'id'=> $this->primaryKey(11),
                'book_id'=> $this->integer(11)->notNull(),
                'name'=> $this->string(255)->null()->defaultValue(null),
                'file'=> $this->string(255)->null()->defaultValue(null),
                'number'=> $this->integer(11)->null()->defaultValue(null),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%book_chapter}}');
    }
}
