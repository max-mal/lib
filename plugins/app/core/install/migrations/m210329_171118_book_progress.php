<?php

use yii\db\Schema;
use yii\db\Migration;

class m210329_171118_book_progress extends Migration
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
            '{{%book_progress}}',
            [
                'id'=> $this->primaryKey(11),
                'book_id'=> $this->integer(11)->notNull(),
                'user_id'=> $this->integer(11)->notNull(),
                'progress'=> $this->integer(11)->notNull(),
                'chapter'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%book_progress}}');
    }
}
