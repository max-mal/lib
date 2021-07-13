<?php

namespace platform\models;

use Yii;
use platform\models\User;

class LoginForm extends \yii2mod\user\models\LoginForm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'string'],
            ['password', 'validatePassword'],
            ['rememberMe', 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Имя пользователя или email',
            'password' => Yii::t('yii2mod.user', 'Password'),
            'rememberMe' => Yii::t('yii2mod.user', 'Remember Me'),
        ];
    }

    /**
     * Finds user
     *
     * @return UserModel|null
     */
    public function getUser()
    {
        if ($this->user === false) {
            $this->user = User::find()->where([
                'or',
                ['email' => $this->email],
                ['username' => $this->email],
            ])->one();
        }

        return $this->user;
    }
}
