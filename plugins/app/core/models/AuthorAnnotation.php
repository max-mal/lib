<?php

namespace app\core\models;

use Yii;

/**
 * This is the model class for table "libaannotations".
 *
 * @property int $AvtorId
 * @property int $nid
 * @property string $Title
 * @property string|null $Body
 */
class AuthorAnnotation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libaannotations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AvtorId', 'nid', 'Title'], 'required'],
            [['AvtorId', 'nid'], 'integer'],
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
            'AvtorId' => 'Avtor ID',
            'nid' => 'Nid',
            'Title' => 'Title',
            'Body' => 'Body',
        ];
    }
}
