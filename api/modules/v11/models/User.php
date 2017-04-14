<?php

namespace api\modules\v11\models;

use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_user".
 *
 * @property integer $id
 * @property integer $cid
 * @property string $username
 * @property string $nickname
 * @property string $avatar
 */
class User extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username', 'avatar','nickname','cid'], 'string', 'max' => 255],
        ];
    }

    // 返回的数据格式化
    public function fields()
    {
        return [
            'id','username','avatar','nickname','cid',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'nickname' => 'Nickname',
            'cid' => 'Cid',
            'avatar' => 'Avatar',
        ];
    }
}
