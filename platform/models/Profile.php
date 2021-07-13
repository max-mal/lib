<?php

namespace platform\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "amylabs_user_profile".
 *
 * @property int $user_id
 * @property string|null $first_name
 * @property string|null $middle_name
 * @property string|null $last_name
 * @property string|null $avatar
 *
 * @property AmylabsUserUser $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    public $uploadedAvatar = null;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['first_name', 'middle_name', 'last_name',], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['uploadedAvatar', 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'first_name' => 'Имя',
            'middle_name' => 'Отчество',
            'last_name' => 'Фамилия',
            'avatar' => 'Аватар',
            'phone' => 'Телефон',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function primaryKey()
    {
        return ['user_id'];
    }

    public function uploadAvatar()
    {

        if (Yii::$app->request->isPost) {
            $file = UploadedFile::getInstance($this, 'uploadedAvatar');
            if (!$file) {
                return true;
            }
            $publicPath = '/uploads/avatars/' . $this->user->username . '.' . $file->extension;
            $file->saveAs(Yii::getAlias('@project') . '/web/static/' . $publicPath);

            $this->avatar = Yii::getAlias('@staticUrl') . $publicPath;
        }

        return true;
    }
}
