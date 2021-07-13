<?php



use yii\db\Schema;
use yii\db\Migration;

class m200606_074606_user_profile extends Migration
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
            '{{%user_profile}}',
            [
                'user_id'=> $this->integer(11)->notNull(),
                'first_name'=> $this->string(255)->null()->defaultValue(null),
                'middle_name'=> $this->string(255)->null()->defaultValue(null),
                'last_name'=> $this->string(255)->null()->defaultValue(null),
                'avatar'=> $this->string(255)->null()->defaultValue(null),
            ],
            $tableOptions
        );
        $this->createIndex('user_profile_user', '{{%user_profile}}', ['user_id'], false);
    }

    public function safeDown()
    {
        $this->dropIndex('user_profile_user', '{{%user_profile}}');
        $this->dropTable('{{%user_profile}}');
    }
}
