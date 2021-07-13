<?php



use yii\db\Schema;
use yii\db\Migration;

class m200606_042335_settings extends Migration
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
            '{{%settings}}',
            [
                'id'=> $this->primaryKey(11),
                'namespace'=> $this->string(255)->notNull(),
                'key'=> $this->string(255)->notNull(),
                'value'=> $this->text()->null()->defaultValue(null),
                'type'=> $this->smallInteger(1)->null()->defaultValue(0),
                'user_id'=> $this->integer(11)->null()->defaultValue(null),
                'created_at'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
                'updated_at'=> $this->timestamp()->null()->defaultValue(null),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%settings}}');
    }
}
