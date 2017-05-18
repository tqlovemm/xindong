<?php

namespace api\modules\v9\models;
use app\components\db\ActiveRecord;
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
