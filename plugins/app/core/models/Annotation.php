<?php

namespace app\core\models;

use Yii;

/**
 * This is the model class for table "libbannotations".
 *
 * @property int $BookId
 * @property int $nid
 * @property string $Title
 * @property string|null $Body
 */
class Annotation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libbannotations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['BookId', 'nid', 'Title'], 'required'],
            [['BookId', 'nid'], 'integer'],
            [['Body'], 'string'],
            [['Title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'BookId' => 'Book ID',
            'nid' => 'Nid',
            'Title' => 'Title',
            'Body' => 'Body',
        ];
    }
}
