<?php

namespace frontend\models;

use Yii;
use app\modules\user\models\User;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "pre_dating_signup_weichat".
 *
 * @property integer $id
 * @property integer $number
 * @property string $openid
 * @property integer $type
 * @property integer $status
 * @property string $like_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $extra
 *
 * @property User $like
 */
class WechatDatingSignup extends \yii\db\ActiveRecord
{
    const STATUS = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_dating_signup_weichat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number'], 'required','message'=>'编号不可为空'],
            ['number', 'validateCheck'],
            [['number','status', 'type', 'created_at', 'updated_at'], 'integer','message'=>'必须为整数'],
            [[ 'extra', 'like_id','openid'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => '编号',
            'openid' => 'Open ID',
            'status' => 'Status',
            'like_id' => 'Like ID',
            'extra' => 'Extra',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function validateCheck(){

        $file = Yii::$app->db->createCommand("select * from {{%flop_content}} where number='{$this->number}'")->queryAll();
        $dating = Yii::$app->db->createCommand("select title from {{%weekly}} where number='{$this->like_id}'")->queryOne();
        $signuped =  Yii::$app->db->createCommand("select * from {{%dating_signup_weichat}} where like_id='{$this->like_id}' and openid='{$this->openid}'")->queryOne();
        $data = ArrayHelper::map($file,'id','area');

        if(empty($file)){

            $this->addError('number','您的会员编号不存在');
        }

        if(!empty($signuped)){

            $this->addError('number','您的微信号已经报过名');
        }

        if(!in_array($dating['title'],$data)){

            $this->addError('number','您所在的地区和妹子所需地区不合');
        }



    }

    public function getNumber(){


        $file = Yii::$app->db->createCommand("select * from {{%flop_content}} where number='{$this->number}'")->queryOne();

        return $file;
       // $signuped =  Yii::$app->db->createCommand("select * from {{%dating_signup_weichat}} where like_id='{$user_info['like_id']}' and openid='{$user_info['openid']}'")->queryOne();

    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {

                $this->created_at = time();
                $this->updated_at = time();
                $this->status = self::STATUS;
            }
            return true;
        } else {
            return false;
        }
    }



}
