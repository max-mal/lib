<?php

namespace app\core\models;

use Yii;

/**
 * This is the model class for table "book_progress".
 *
 * @property int $id
 * @property int|null $book_id
 * @property int|null $user_id
 * @property int|null $progress
 * @property int|null $chapter
 */
class BookProgress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_progress';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'user_id', 'progress', 'chapter'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'book_id' => 'Book ID',
            'user_id' => 'User ID',
            'progress' => 'Progress',
            'chapter' => 'Chapter',
        ];
    }
}
