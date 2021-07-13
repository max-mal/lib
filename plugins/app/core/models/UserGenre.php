<?php

namespace app\core\models;

use Yii;

/**
 * This is the model class for table "user_genre".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $genre_id
 */
class UserGenre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_genre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'genre_id'], 'integer'],
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
            'genre_id' => 'Genre ID',
        ];
    }
}
