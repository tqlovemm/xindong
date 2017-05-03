<?php
namespace api\modules\v11\models;

use app\components\db\ActiveRecord;
/**
 * This is the model class for table "pre_app_form_thread_report".
 *
 * @property integer $rep_id
 * @property integer $report_id
 * @property integer $user_id
 * @property integer $wid
 * @property integer $created_at
 * @property integer $updated_at
 */
class FormThreadReport extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%app_form_thread_report}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['report_id','user_id','wid'], 'required','message'=>"{attribute}不可为空"],
            [['report_id','user_id','wid','created_at','updated_at'], 'integer'],
        ];
    }

    public function fields(){

        return [
            'rep_id','report_id',
            'user_id','wid',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rep_id' => 'Rep ID',
            'report_id' => 'Report ID',
            'user_id'=>'User Id',
            'wid'=>'WID',
            'created_at'=>'Created At',
            'updated_at'=>'Updated At',
        ];
    }
}
