<?php

namespace backend\modules\financial\models;

use Yii;

/**
 * This is the model class for table "pre_financial_wechat_platform".
 *
 * @property integer $id
 * @property string $platform_name
 * @property string $remarks
 */
class FinancialWechatPlatform extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_financial_wechat_platform';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['platform_name'], 'required'],
            [['platform_name'], 'string', 'max' => 64],
            [['remarks'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'platform_name' => 'Platform Name',
            'remarks' => 'Remarks',
        ];
    }
}
