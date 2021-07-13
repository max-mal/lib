<?php

use yii\db\Schema;
use yii\db\Migration;

class m200606_083720_auth_itemDataInsert extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->batchInsert(
            '{{%auth_item}}',
            ["name", "type", "description", "rule_name", "data", "created_at", "updated_at"],
            [
            [
            'name' => 'admin',
            'type' => '1',
            'description' => null,
            'rule_name' => null,
            'data' => null,
            'created_at' => '1591430442',
            'updated_at' => '1591430442',
            ],
                            ]
        );
    }

    public function safeDown()
    {
        //$this->truncateTable('{{%auth_item}} CASCADE');
    }
}
