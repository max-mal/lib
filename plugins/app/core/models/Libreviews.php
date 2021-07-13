<?php

namespace app\core\models;

use Yii;

/**
 * This is the model class for table "libreviews".
 *
 * @property string $Name
 * @property string $Time
 * @property int $BookId
 * @property string $Text
 */
class Libreviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libreviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name', 'BookId', 'Text'], 'required'],
            [['Time'], 'safe'],
            [['BookId'], 'integer'],
            [['Text'], 'string'],
            [['Name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Name' => 'Name',
            'Time' => 'Time',
            'BookId' => 'Book ID',
            'Text' => 'Text',
        ];
    }
}
