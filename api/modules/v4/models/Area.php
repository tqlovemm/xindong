<?php

namespace api\modules\v4\models;

use app\components\db\ActiveRecord;
use Yii;


/**
 * This is the model class for table "pre_weekly".
 *
 * @property string $title
 */
class Area extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%weekly}}';
    }

    public function rules()
    {
        return [


            [['title'], 'string'],
        ];
    }
    public function attributeLabels()
    {
        return [


            'title' => '地区',
        ];
    }

    public function fields()
    {

        return [

            'area'=>'title',

        ];

    }


}


?>
