<?php

namespace api\modules\v3\models;

use app\components\db\ActiveRecord;
use Yii;



/**
 * This is the model class for table "pre_app_push".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $type
 * @property integer $message_id
 * @property integer $is_read
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $cid
 * @property string $icon
 * @property string $title
 * @property string $platform
 * @property string $msg
 * @property string $extras
 * @property string $response
 */
class AppPush extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%app_push}}';
    }


    public function getId()
    {
        return $this->id;
    }


    public function rules()
    {
        return [

            [['is_read'],'required'],
            [['cid','msg','extras','response','title','icon'], 'string'],
            [['status','created_at','updated_at','is_read'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'msg' => '推送内容',
            'extras' => '推送内容json',
            'title' => '推送标题',
            'response' => '响应',
            'cid' => 'app唯一标识',
            'status' => '状态',
            'is_read' => '阅读',
            'icon' => '图标',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',

        ];
    }


    // 返回的数据格式化
    public function fields()
    {
        return [

            'push_id'=>'id','title','msg','status',
            'cid',
            'created_at','updated_at','is_read',
            'icon',
            'response',

            'extras'=>function($model){


                return json_decode(urldecode($model['extras']));

            },
            'message_id',

        ];

    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->updated_at = time();
                $this->response = "NULL";
                $this->platform = 'all';
            }
            return true;
        }
        return false;
    }


}
