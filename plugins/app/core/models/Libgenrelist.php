<?php

namespace app\core\models;

use Yii;

/**
 * This is the model class for table "libgenrelist".
 *
 * @property int $GenreId
 * @property string $GenreCode
 * @property string $GenreDesc
 * @property string $GenreMeta
 */
class Libgenrelist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libgenrelist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['GenreCode'], 'required'],
            [['GenreCode', 'GenreMeta'], 'string', 'max' => 45],
            [['GenreDesc'], 'string', 'max' => 99],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'GenreId' => 'Genre ID',
            'GenreCode' => 'Genre Code',
            'GenreDesc' => 'Genre Desc',
            'GenreMeta' => 'Genre Meta',
        ];
    }

    public function getBooks()
    {
        return $this->hasMany(Libbook::class, ['BookId' => 'BookId'])->viaTable('libgenre', ['GenreId' => 'GenreId']);
    }
}
