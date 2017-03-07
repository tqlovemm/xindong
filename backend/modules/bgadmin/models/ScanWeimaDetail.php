<?php

namespace backend\modules\bgadmin\models;

use frontend\modules\weixin\models\ScanWeimaRecord;
use Yii;

/**
 * This is the model class for table "pre_scan_weima_detail".
 *
 * @property integer $sence_id
 * @property string $customer_service
 * @property string $account_manager
 * @property string $description
 * @property string $local_path
 * @property string $remote_path
 */
class ScanWeimaDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_scan_weima_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_service', 'account_manager'], 'required'],
            [['customer_service', 'account_manager'], 'string', 'max' => 64],
            [['description','local_path','remote_path'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sence_id' => 'Sence ID',
            'customer_service' => '客服人员',
            'account_manager' => '博主',
            'description' => '描述',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNum()
    {
        return $this->hasMany(ScanWeimaRecord::className(), ['scene_id' => 'sence_id'])->where(['status'=>1]);
    }
}
