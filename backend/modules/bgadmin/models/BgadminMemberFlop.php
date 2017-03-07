<?php

namespace backend\modules\bgadmin\models;

use Yii;

/**
 * This is the model class for table "pre_bgadmin_member_flop".
 *
 * @property integer $id
 * @property string $floping_number
 * @property string $floped_number
 * @property string $created_at
 * @property string $updated_at
 * @property string $created_by
 */
class BgadminMemberFlop extends \yii\db\ActiveRecord
{
    public $floped;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_bgadmin_member_flop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['floping_number', 'floped'], 'required'],
            [['floping_number', 'floped_number','created_by'], 'string', 'max' => 32],
            [['created_at', 'updated_at'], 'string', 'max' => 11],
            [['floped'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */

    public function beforeSave($insert)
    {

        if(parent::beforeSave($insert)){

            if($this->isNewRecord){

                $this->created_at = time();
                $this->updated_at = time();
                $this->created_by = Yii::$app->user->identity->username;

            }else{

                $this->updated_at = time();
            }

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '记录ID',
            'floping_number' => '翻牌者编号',
            'floped_number' => '被翻牌者编号',
            'created_at' => '创建时间',
            'created_by' => '创建人',
            'updated_at' => '修改时间',
        ];
    }
}
