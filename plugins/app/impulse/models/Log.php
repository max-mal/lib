<?php

namespace app\impulse\models;

use platform\models\User;
use app\impulse\components\Impulse;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%impulse_log}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $level
 * @property string $category
 * @property string $message
 * @property string $ip
 * @property string $url
 * @property string $created_at
 *
 * @property User $user
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%impulse_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'level'], 'integer'],
            [['message'], 'string'],
            [['created_at'], 'safe'],
            [['category', 'ip'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 512],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'level' => 'Уровень',
            'category' => 'Категория',
            'message' => 'Сообщение',
            'ip' => 'IP',
            'url' => 'URL',
            'created_at' => 'Создано',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getLevelsList()
    {
        return [
            Impulse::LEVEL_ERROR => 'error',
            Impulse::LEVEL_WARNING => 'warning',
            Impulse::LEVEL_INFO => 'info',
            Impulse::LEVEL_TRACE => 'trace',
        ];
    }

    public function getLevelTitle()
    {
        return ArrayHelper::getValue(self::getLevelsList(), $this->level);
    }

    public static function getCategoriesList()
    {
        $data = Log::find()->select('category')->distinct()->orderBy('category')->column();

        return array_combine($data, $data);
    }
}
