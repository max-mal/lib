<?php

namespace platform\models;

use yii2mod\user\models\UserModel;

class User extends UserModel
{
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'id']);
    }

    public function getFullName()
    {
        if ($this->profile && $this->profile->first_name) {
            return $this->profile->first_name . ' ' . $this->profile->last_name;
        }

        return $this->username;
    }

    public function afterFind()
    {

        parent::afterFind();

        if (!$this->profile && $this->id) {
            $profile = new Profile();
            $profile->user_id = $this->id;
            $profile->save();
        }
    }
}
