<?php

namespace app\core\models;

use Yii;

/**
 * This is the model class for table "libgenre".
 *
 * @property int $Id
 * @property int $BookId
 * @property int $GenreId
 */
class Libgenre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libgenre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['BookId', 'GenreId'], 'integer'],
            [['BookId', 'GenreId'], 'unique', 'targetAttribute' => ['BookId', 'GenreId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'BookId' => 'Book ID',
            'GenreId' => 'Genre ID',
        ];
    }
}
