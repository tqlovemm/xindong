<?php

namespace api\modules\v4\models;

use app\components\db\ActiveRecord;
use Yii;
use yii\db\Query;


/**
 * This is the model class for table "pre_user".
 *
 * @property integer $id
 * @property integer $groupid
 * @property string $avatar
 * @property string $username
 * @property string $nickname
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $status
 */
class Member extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%user}}';
    }
    
    public function rules()
    {
        return [

            [['avatar','nickname','username'], 'string'],
            [['id','groupid','created_at','updated_at','status'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'groupid' => '用户组',
            'username' => '用户名',
            'nickname' => '用户昵称',
            'avatar' => '头像',
            'updated_at' => 'Updated At',
            'created_at' => 'Updated At',
            'status' => '状态',

        ];
    }

    public function getInfo(){

        $credit = (new Query())->select('levels,viscosity,lan_skills,sex_skills,appearance')->from("{{%credit_value}}")->where(['user_id'=>$this->id])->one();

        if(empty($credit)){

            Yii::$app->db->createCommand()->insert('{{%credit_value}}',[
                'user_id'=>$this->id,
                'created_at'=>time(),
                'updated_at'=>time()
            ])->execute();
        }

        $query = Yii::$app->db->createCommand("select ud.jiecao_coin,cv.levels,cv.viscosity,cv.lan_skills,cv.sex_skills,cv.appearance from {{%user_data}} as ud left join {{%credit_value}} as cv on cv.user_id=ud.user_id where ud.user_id=$this->id")->queryOne();

        $group = array(1=>"网站会员",2=>'普通会员',3=>'高端会员',4=>'至尊会员',5=>'私人订制');

        $query['degree']=$group[$this->groupid];

        return $query;
    }
    public function extraFields()
    {
        return [
            'info'=>'info',
        ];
    }
    // 返回的数据格式化
    public function fields()
    {
/*      $fields = parent::fields();
        $fields["dating_id"] = $fields['id'];
    //  remove fields that contain sensitive information
        unset($fields['id']);*/

        return [

            'user_id'=>'id','username','nickname','created_at','avatar'

        ];

    }




}
