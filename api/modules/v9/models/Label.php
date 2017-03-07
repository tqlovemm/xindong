<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/13
 * Time: 15:21
 */

namespace api\modules\v9\models;

use Yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "pre_app_label".
 *
 * @property integer $id;
 * @property integer $label;
 * @property integer $created_at;
 * @property integer $updated_at;
 *
 */
class Label extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%app_label}}';
    }

    public function rules()
    {
        return [
            [['id','created_at','updated_at',],'integer'],
            [['label',],'string','max'=>30],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id'    =>  'Id',
            'label'    =>  '标签',
            'updated_at'    =>  'updated_at',
            'created_at'    =>  'created_at',

        ];
    }

    public function fields()
    {
        return [
          'id','label'
        ];
    }
}