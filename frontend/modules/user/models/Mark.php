<?php
/**
 * Created by PhpStorm.
 * User: tqmm
 * Date: 15-11-30
 * Time: 下午6:07
 */

namespace app\modules\user\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_mark}}".
 *
 * @property string $mark_name
 * @property string $make_friend_name
 * @property string $hobby_name
 */
class Mark extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%user_mark}}';
    }

    public function rules()
    {
        return[

            [['mark_name','make_friend_name','hobby_name'], 'required'],


        ];
    }

    public function attributeLabels()
    {
        return [
            'mark_name' => '我的标签',
            'make_friend_name' => '交友要求',
            'hobby_name' => '兴趣爱好',

        ];
    }


}