<?php
namespace api\modules\v8\models;

use Yii;
use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_hx_group".
 *
 * @property integer $id
 * @property string $g_id
 * @property string $avatar
 * @property string $thumb
 * @property string $groupname
 * @property string $owner
 * @property string $affiliations
 * @property integer $created_at
 * @property integer $updated_at
 */
class HxGroup extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%hx_group}}";
    }

    public function rules()
    {
        return [
            [['g_id'],'required'],
            [['id','created_at','updated_at','affiliations'],'integer'],
            [['avatar','g_id','thumb','groupname','owner'],'string']
        ];
    }

    public function AttributeLabel()
    {
        return [
            'id'    =>  'id',
            'g_id'  =>  'group Id',
            'avatar'=>  'avatar',
            'thumb' =>  'thumb',
            'groupname' =>  'groupname',
            'owner' =>  'owner',
            'affiliations' =>  'affiliations',
            'created_at'    =>  'created_at',
            'updated_at'    =>  'updated_at',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }

    public function fields()
    {
        return [
            'id','g_id','thumb'=>function($model){

                return Yii::$app->params['appimages'].$model->thumb;
            },
            'created_at',"groupname",'owner','affiliations',
        ];
    }
}