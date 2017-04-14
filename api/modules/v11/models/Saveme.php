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
            [['created_id', 'address_id', 'content', 'end_time', 'status'], 'required'],
            [['created_id', 'address_id', 'created_at', 'end_time', 'status','updated_at'], 'integer'],
            [['content'], 'string', 'max' => 255]
        ];
    }

    public function fields(){

        return [
            'id','created_id', 'content', 'created_at','end_time', 'status', 'prov_name','photos',
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
            'address_id' => '地点id',
            'content' => '要求',
            'end_time' => '截止时间',
            'updated_at' => 'updated_at',
            'status' => '状态',
        ];
    }

    public function getprov_name(){

        $province = Yii::$app->db->createCommand("select prov_name from {{%province}} where prov_id=$this->address_id")->queryOne();

        return $province['prov_name'];
    }

    public function getPhotos(){

        $photo = Yii::$app->db->createCommand("select path from {{%saveme_img}} where saveme_id=$this->id")->queryAll();

        return $photo;
    }
}
