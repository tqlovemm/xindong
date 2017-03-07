<?php

namespace api\modules\v4\models;

use app\components\db\ActiveRecord;
use Yii;


/**
 * This is the model class for table "app_complaint".
 *
 * @property integer $id
 * @property integer $plaintiff_id
 * @property integer $defendant_id
 * @property integer $status
 * @property string $reason
 * @property string $type
 */
class Complaint extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%app_complaint}}';
    }

    public function rules()
    {
        return [

            [['type','plaintiff_id','defendant_id'],'required'],
            [['id','plaintiff_id','defendant_id','status'],'integer'],
            [['type','reason','created_at','updated_at'], 'string'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'plaintiff_id' => 'Plaintiff ID',
            'defendant_id' => 'Defendant ID',
            'status' => 'Status',
            'reason' => 'Reason',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function fields()
    {
        return [
            'complaint_id'=>'id',
            'type',
            'defendant_id',
            'plaintiff_id',
            'created_at',
            'updated_at'
        ];
    }
}


?>
