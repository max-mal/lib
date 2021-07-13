<?php

namespace app\core\models;

use Yii;

/**
 * This is the model class for table "libavtor".
 *
 * @property int $BookId
 * @property int $AvtorId
 * @property int $Pos
 */
class Libavtor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libavtor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['BookId', 'AvtorId'], 'required'],
            [['BookId', 'AvtorId', 'Pos'], 'integer'],
            [['BookId', 'AvtorId'], 'unique', 'targetAttribute' => ['BookId', 'AvtorId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'BookId' => 'Book ID',
            'AvtorId' => 'Avtor ID',
            'Pos' => 'Pos',
        ];
    }
}
