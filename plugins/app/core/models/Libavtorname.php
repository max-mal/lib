<?php

namespace app\core\models;

use Yii;
use yii\helpers\Url;
/**
 * This is the model class for table "libavtorname".
 *
 * @property int $AvtorId
 * @property string $FirstName
 * @property string $MiddleName 
 * @property string $LastName
 * @property string $NickName
 * @property int $uid
 * @property string $Email
 * @property string $Homepage
 * @property string $Gender
 * @property int $MasterId
 */
class Libavtorname extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $count = 0;

    public static function tableName()
    {
        return 'libavtorname';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'MasterId'], 'integer'],
            [['Email', 'Homepage'], 'required'],
            [['FirstName', 'MiddleName', 'LastName'], 'string', 'max' => 99],
            [['NickName'], 'string', 'max' => 33],
            [['Email', 'Homepage'], 'string', 'max' => 255],
            [['Gender'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'AvtorId' => 'Avtor ID',
            'FirstName' => 'First Name',
            'MiddleName' => 'Middle Name',
            'LastName' => 'Last Name',
            'NickName' => 'Nick Name',
            'uid' => 'Uid',
            'Email' => 'Email',
            'Homepage' => 'Homepage',
            'Gender' => 'Gender',
            'MasterId' => 'Master ID',
        ];
    }

    public function getBooks()
    {
        return $this->hasMany(Libbook::class, ['BookId' => 'BookId'])->viaTable('libavtor', ['AvtorId' => 'AvtorId']);
    }


    public function getAnnotation()
    {
        return $this->hasOne(AuthorAnnotation::class, ['AvtorId' => 'AvtorId']);
    }

    public function getPic()
    {
        return $this->hasOne(AuthorPic::class, ['AvtorId' => 'AvtorId']);
    }

    public function getPicture()
    {
        return Yii::$app->request->hostInfo . Url::to(['/api/author/image', 'id' => $this->AvtorId, 'token' => Yii::$app->request->get('token', '')]);
    }

    public function getDescription()
    {
        return $this->annotation? $this->annotation->Body : '';
    }
}
