<?php

namespace app\core\models;

use Yii;

/**
 * This is the model class for table "libseqname".
 *
 * @property int $SeqId
 * @property string $SeqName
 */
class Libseqname extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libseqname';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SeqName'], 'string', 'max' => 254],
            [['SeqName'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SeqId' => 'Seq ID',
            'SeqName' => 'Seq Name',
        ];
    }
}
