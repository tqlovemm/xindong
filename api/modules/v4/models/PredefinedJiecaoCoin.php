<?php

namespace api\modules\v4\models;

use app\components\db\ActiveRecord;
use Yii;


/**
 * This is the model class for table "pre_predefined_jiecao_coin".
 *
 * @property integer $id
 * @property integer $money
 * @property integer $status
 * @property integer $giveaway
 * @property integer $type
 * @property integer $member_type
 * @property integer $is_activity
 */
class PredefinedJiecaoCoin extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%predefined_jiecao_coin}}';
    }

    public function rules()
    {
        return [

            [['money','status','giveaway','type','member_type','is_activity'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [

            'money' => 'Money',
            'giveaway' => 'Giveaway',
            'status' => 'Status',
            'type' => 'Type',
            'member_type' => 'Member Type',
            'is_activity' => 'IS Activity',
        ];
    }

    public function fields()
    {

        return [

            'money'=>function($model){

                return (string)$model['money'];
            },
            'giveaway'=>function($model){

                return (string)$model['giveaway'];
            },
            'status'=>function($model){

                return (string)$model['status'];
            },
            'type'=>function($model){

                return (string)$model['type'];
            },
            'member_type'=>function($model){

                return (string)$model['member_type'];
            },
            'is_activity'=>function($model){

                return (string)$model['is_activity'];
            },

        ];

    }


}


?>
