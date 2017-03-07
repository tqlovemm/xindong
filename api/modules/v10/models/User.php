<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/6
 * Time: 14:51
 */

namespace api\modules\v10\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $avatar
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access-token' => $token]);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['role', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'avatar', 'password_hash', 'password_reset_token', 'email','nickname'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32]
        ];
    }

    // 返回的数据格式化
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['auth_key'],$fields['password_hash'], $fields['password_reset_token'],$fields['avatarid'],$fields['avatartemp'],$fields['role']);
        return $fields;
    }

    public function getThread(){
        $min_id = isset($_GET['min_id'])?$_GET['min_id']:0;
        if($min_id!=0){
            $model = Yii::$app->db->createCommand("select t.id as thread_id,t.content,t.created_at,t.updated_at,t.post_count,t.note,t.read_count,t.is_stick,t.image_path from {{%forum_thread}} as t WHERE t.user_id=".$this->id." and id<".$min_id." order by created_at desc limit 5")->queryAll();
        }else{

            $model = Yii::$app->db->createCommand("select t.id as thread_id,t.content,t.created_at,t.updated_at,t.post_count,t.note,t.read_count,t.is_stick,t.image_path from {{%forum_thread}} as t WHERE t.user_id=".$this->id." order by created_at desc limit 20")->queryAll();
        }

        for($i=0;$i<count($model);$i++){

            $model[$i]['image_path'] = json_decode($model[$i]['image_path']);
            $preg = "/<\/?[^>]+>/i";
            $model[$i]['content'] = trim(preg_replace($preg,'',$model[$i]['content']),'&nbsp;');
            $time = (integer)$model[$i]['created_at'];
            $model[$i]['created_at'] = $time;
        }
        return $model;
    }

    public function extraFields()
    {
        return [
            'thread'=>'thread',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'avatar' => '头像',
            //'auth_key' => 'Auth Key',
            //'password_hash' => 'Password Hash',
            //'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'role' => 'Role',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
