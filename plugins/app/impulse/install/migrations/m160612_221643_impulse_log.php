<?php

class m160612_221643_impulse_log extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable(
            '{{%impulse_log}}',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer()->comment('Пользователь'),
                'level' => $this->smallInteger()->comment('Уровень'),
                'category' => $this->string()->comment('Категория'),
                'message' => $this->text()->comment('Сообщение'),
                'ip' => $this->string(),
                'url' => $this->string('512')->comment('URL'),
                'created_at' => $this->timestamp()->notNull()->defaultExpression('current_timestamp')->comment('Создано'),
            ],
            'ENGINE=InnoDB'
        );
    }

    public function down()
    {
        $this->dropTable('{{%impulse_log}}');
    }
}
