<?php

namespace frontend\modules\bgadmin\models;

use Yii;

/**
 * This is the model class for table "pre_user_mark".
 *
 * @property integer $id
 * @property string $mark_name
 * @property string $make_friend_name
 * @property string $hobby_name
 */
class UserMark extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_user_mark';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mark_name', 'make_friend_name', 'hobby_name'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mark_name' => 'Mark Name',
            'make_friend_name' => 'Make Friend Name',
            'hobby_name' => 'Hobby Name',
        ];
    }
}
