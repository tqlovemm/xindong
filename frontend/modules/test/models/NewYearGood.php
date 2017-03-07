<?php

namespace frontend\modules\test\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "pre_new_year_good".
 *
 * @property integer $id
 * @property integer $da_id
 * @property string $sayGood
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property WeichatDazzle $da
 */
class NewYearGood extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_new_year_good';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['da_id', 'sayGood'], 'required'],
            [['da_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['sayGood'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'da_id' => 'Da ID',
            'sayGood' => 'Say Good',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function fields()
    {
        return [
            'id','da_id','sayGood','created_at','updated_at','info','img',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    //投票人信息1
    public function getDa()
    {
        return (new Query())->select("id,sex,num")->from("pre_new_year as ny")->where(['ny.openId'=>$this->sayGood])->one();

    }

    //投票人照片1
    public function getImg(){
        $openId = (new Query())->select('id')->from('pre_new_year')->where(['openId'=>$this->sayGood])->one();
        return (new Query())->select("thumb")->from("pre_new_year_img as img")->where(['img.da_id'=>$openId])->one();
    }

    //被投票人信息2
    public function getDa2(){
        return (new Query())->select("id,sex,num")->from("pre_new_year as ny")->where(['ny.id'=>$this->da_id])->one();
    }
    //被投票人照片2
    public function getImg2(){
        return (new Query())->select("thumb")->from("pre_new_year_img as img")->where(['img.da_id'=>$this->da_id])->one();
    }
}
