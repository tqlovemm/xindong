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

            [['money','status','giveaway'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [

            'money' => 'Money',
            'giveaway' => 'Giveaway',
            'status' => 'Status',
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

        ];

    }


}


?>
