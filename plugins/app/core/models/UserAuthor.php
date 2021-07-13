<?php

namespace app\core\models;

use Yii;

/**
 * This is the model class for table "user_author".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $author_id
 */
class UserAuthor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'author_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'author_id' => 'Author ID',
        ];
    }
}
