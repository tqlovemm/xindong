<?php

namespace api\modules\v9\models;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pre_app_special_dating_sign_up".
 *
 * @property integer $sid
 * @property integer $user_id
 * @property integer $zid
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $status
 *
 */
class AppSpecialDatingSignUp extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_app_special_dating_sign_up';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'zid'], 'required','message'=>'{attribute}不可为空'],
            [['user_id', 'zid', 'created_at', 'updated_at', 'status', 'created_by'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sid' => 'SID',
            'user_id' => '用户ID',
            'zid' => '专属女生编号',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'status' => '审核状态',
            'created_by' => '审核人',
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

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub

        $model = AppSpecialDating::findOne($this->zid);
        $model->sign_up_count += 1;
        $model->update();
    }

    public function getZinfo()
    {
        return $this->hasOne(AppSpecialDating::className(), ['zid' => 'zid'])->asArray();
    }

    public function getZimg(){
        return $this->hasMany(AppSpecialDatingImages::className(), ['zid' => 'zid'])->asArray();
    }

    public function getCover(){

        return $this->hasOne(AppSpecialDatingImages::className(), ['zid' => 'zid'])->where(['type'=>1])->asArray();
    }

    public function fields()
    {
        return [
            'sid','user_id', 'zid', 'created_at','status',
            'info'=>function(){
                return AppSpecialDating::findOne(['zid'=>$this->zid]);
            }
        ];
    }

}
