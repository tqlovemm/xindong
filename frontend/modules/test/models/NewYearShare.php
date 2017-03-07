<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/9
 * Time: 16:57
 */

namespace frontend\modules\test\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%new_year_share}}".
 *
 * @property integer $id
 * @property integer $who_share
 * @property integer $for_who
 * @property integer $flag
 * @property integer $updated_at
 * @property integer $created_at
 */
class NewYearShare extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%new_year_share}}';
    }

    public function rules()
    {
        return [
            [['who_share','for_who'],'required'],
            [['id','who_share','for_who','flag','updated_at','created_at'],'integer'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id'    =>  'Id',
            'who_share'    =>  '分享者',
            'for_who'    =>  '被分享者',
            'flag'    =>  '是否已分享（1是）',
            'updated_at'    =>  'updated_at',
            'created_at'    =>  'created_at',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->updated_at = time();
            }else{
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }
}