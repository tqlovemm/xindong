<?php

namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_saveme".
 *
 * @property string $id
 * @property string $created_id
 * @property integer $address
 * @property string $content
 * @property integer $end_time
 * @property integer $status
 */
class Saveme extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%saveme}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_id', 'address', 'content', 'end_time', 'price', 'status'], 'required'],
            [['created_id', 'created_at', 'end_time', 'status', 'price','updated_at'], 'integer'],
            [['content', 'address'], 'string', 'max' => 255]
        ];
    }

    public function fields(){

        return [
            'saveme_id'=>'id','created_id', 'address', 'content', 'price', 'created_at','end_time','nickname', 'status', 'photos',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_id' => '发布人',
            'address' => '地点',
            'content' => '要求',
            'price' => '需要节操币',
            'end_time' => '截止时间',
            'updated_at' => 'updated_at',
            'status' => '状态',
        ];
    }

    public function getPhotos(){

        $photo = Yii::$app->db->createCommand("select path from {{%saveme_img}} where saveme_id=$this->id")->queryAll();

        return $photo;
    }

    public function getnickname(){
        $user = Yii::$app->db->createCommand("select nickname from {{%user}} where id=$this->created_id")->queryAll();

        return $user[0]['nickname'];
    }
}
