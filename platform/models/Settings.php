<?php

namespace platform\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string $namespace
 * @property string $key
 * @property string|null $value
 * @property int|null $type
 * @property int|null $user_id
 * @property string $created_at
 * @property string|null $updated_at
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['namespace', 'key'], 'required'],
            [['value'], 'string'],
            [['type', 'user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['namespace', 'key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'namespace' => 'Namespace',
            'key' => 'Key',
            'value' => 'Value',
            'type' => 'Type',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
