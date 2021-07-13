<?php

namespace app\core\models;

use Yii;

/**
 * This is the model class for table "librate".
 *
 * @property int $ID
 * @property int $BookId
 * @property int $UserId
 * @property string $Rate
 */
class Librate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'librate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['BookId', 'UserId', 'Rate'], 'required'],
            [['BookId', 'UserId'], 'integer'],
            [['Rate'], 'string', 'max' => 1],
            [['BookId', 'UserId'], 'unique', 'targetAttribute' => ['BookId', 'UserId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'BookId' => 'Book ID',
            'UserId' => 'User ID',
            'Rate' => 'Rate',
        ];
    }
}
