<?php

namespace platform\components;

use yii\base\Component;
use platform\models\User;
use platform\models\Profile;

class UserManager extends Component
{
    public function createUser($username, $email, $password = null, $userAttributes = [], $profileAttributes = [])
    {
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->plainPassword = $password;
        $user->setAttributes($userAttributes);

        if (!$user->create()) {
            return null;
        }

        if (!$user->profile) {
            $profile = new Profile();
            $profile->user_id = $user->id;
        } else {
            $profile = $user->profile;
        }
        
        $profile->setAttributes($profileAttributes);
        $profile->save();

        return $user;
    }
}
