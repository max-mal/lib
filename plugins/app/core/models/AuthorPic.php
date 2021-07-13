<?php

namespace app\core\models;

use Yii;

/**
 * This is the model class for table "libapics".
 *
 * @property int $AvtorId
 * @property int $nid
 * @property string $File
 */
class AuthorPic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libapics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AvtorId', 'nid', 'File'], 'required'],
            [['AvtorId', 'nid'], 'integer'],
            [['File'], 'string', 'max' => 255],
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
            'File' => 'File',
        ];
    }
}
