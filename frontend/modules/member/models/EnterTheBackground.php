<?php

namespace frontend\modules\member\models;

use Yii;

/**
 * This is the model class for table "pre_enter_the_background".
 *
 * @property integer $id
 * @property string $allow_ip
 * @property string $forbid_ip
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $created_by
 */
class EnterTheBackground extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_enter_the_background';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allow_ip'], 'required'],
            [['allow_ip'], 'attrY'],
            [['allow_ip'], 'local'],
            [['created_at', 'updated_at'], 'integer'],
            [['allow_ip', 'forbid_ip'], 'string', 'max' => 16],
            [['created_by'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attrY(){

        if(!preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/", $this->allow_ip)) {
            $this->addError('allow_ip', 'ip格式错误');
        }
        if(self::findOne(['allow_ip'=>$this->allow_ip])){
            $this->addError('allow_ip', '已经存在该IP地址');
        }
    }

    public function local(){

        $add = $this->GetIpLookup($this->allow_ip);
        if($add['city']!='苏州'){
            $this->addError('allow_ip', '您的IP不被允许');
        }

    }

    public function GetIpLookup($ip){
        $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
        if(empty($res)){ return false; }
        $jsonMatches = array();
        preg_match('#\{.+?\}#', $res, $jsonMatches);
        if(!isset($jsonMatches[0])){ return false; }
        $json = json_decode($jsonMatches[0], true);
        if(isset($json['ret']) && $json['ret'] == 1){
            $json['ip'] = $ip;
            unset($json['ret']);
        }else{
            return false;
        }
        return $json;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'allow_ip' => 'Allow Ip',
            'forbid_ip' => 'Forbid Ip',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = time();
                $this->created_by = Yii::$app->user->identity->username;
            }
            $this->updated_at = time();
            return true;
        } else {
            return false;
        }
    }
}
