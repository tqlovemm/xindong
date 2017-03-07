<?php
namespace backend\modules\seventeen\models;

/**
 * This is the model class for table "pre_collecting_17_wei_user".
 *
 * @property integer $id
 * @property string $openid
 * @property string $nickname
 * @property string $headimgurl
 * @property string $address
 * @property string $flag
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $expire
 */
class SeventeenWeiUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_collecting_17_wei_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status','created_at','updated_at','expire'], 'integer'],
            [['openid','flag','nickname'], 'string', 'max' => 64],
            [['address','headimgurl'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '会员编号',
            'openid' => '微信识别码',
            'nickname' => '微信昵称',
            'headimgurl' => '微信头像',
            'address' => '所选择的地区',
            'status' => 'Status',
            'flag' => 'Flag',
            'expire' => 'Expire',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($this->isNewRecord) {
                $this->created_at = time();
                $this->updated_at = time();
                $this->status = 0;
            }else{
                $this->updated_at = time();
            }

            return true;

        } else {
            return false;
        }
    }
}
