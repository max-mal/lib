<?php

namespace app\core\models;

use Yii;

/**
 * This is the model class for table "book_chapter".
 *
 * @property int $id
 * @property int|null $book_id
 * @property string|null $name
 * @property string|null $file
 * @property int|null $number
 */
class BookChapter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_chapter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'number'], 'integer'],
            [['name', 'file'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'file' => 'File',
            'number' => 'Number',
        ];
    }
}
