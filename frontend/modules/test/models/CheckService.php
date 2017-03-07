<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/5
 * Time: 9:45
 */
namespace frontend\modules\test\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%check_service}}".
 *
 * @property integer $id
 * @property string $number
 * @property integer $flag
 * @property integer $updated_at
 * @property integer $created_at
 */

class CheckService extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%check_service}}";
    }

    public function rules()
    {
        return [
            [['number'],'required'],
            [['number','avatar','nickname'],'string'],
            [['id','flag','created_at','updated_at'],'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'    =>  'id',
            'number'    =>  '客服号',
            'avatar'    =>  'avatar',
            'nickname'  =>  'nickname',
            'flag'  =>  'flag',
            'created_at'    =>  'created_at',
            'updated_at'    =>  'updated_at',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }
}