<?php

namespace app\core\models;

use Yii;

/**
 * This is the model class for table "user_collection_book".
 *
 * @property int $id
 * @property int|null $collection_id
 * @property int|null $book_id
 */
class UserCollectionBook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_collection_book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['collection_id', 'book_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'collection_id' => 'Collection ID',
            'book_id' => 'Book ID',
        ];
    }
}
