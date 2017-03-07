<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/6
 * Time: 16:40
 */

namespace frontend\modules\test\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%check_service}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $instruction
 * @property string $rule
 * @property string $inline_time
 * @property string $weibo
 * @property string $explain
 * @property integer $updated_at
 * @property integer $created_at
 */
class UserHowPlay extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%user_how_play}}';
    }

    public function rules()
    {
        return [
            [['id','updated_at','created_at'],'integer'],
            [['title','explain'],'string','max'=>250],
            [['instruction','rule','inline_time','weibo'],'string','max'=>800],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'    =>  'Id',
            'title'    =>  'title',
            'instruction'    =>  'instruction',
            'rule'    =>  'rule',
            'inline_time'    =>  'inline_time',
            'weibo'    =>  'weibo',
            'explain'    =>  'explain',
            'updated_at'    =>  'updated_at',
            'created_at'    =>  'created_at',
        ];
    }
}