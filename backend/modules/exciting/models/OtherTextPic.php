<?php
namespace backend\modules\exciting\models;

/**
 * This is the model class for table "{{%all_other_text_pic}}".
 *
 * @property string $pid
 * @property string $tid
 * @property string $number
 * @property string $name
 * @property string $city
 * @property string $content
 * @property string $pic_path
 * @property integer $created_at
 * @property integer $type
 * @property integer $coin
 * @property integer $expire
 * @property integer $status
 */
class OtherTextPic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%all_other_text_pic}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tid', 'name', 'content', 'pic_path'], 'required'],
            [['tid', 'created_at', 'type', 'status','coin','expire'], 'integer'],
            [['name','city'], 'string', 'max' => 32],
            [['number'], 'string', 'max' => 16],
            [['content', 'pic_path'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pid' => 'PID',
            'tid' => 'TID',
            'number' => 'Number',
            'name' => '地区',
            'content' => '描述',
            'pic_path' => 'Pic Path',
            'created_at' => 'Created At',
            'type' => 'Type',
            'coin' => 'Coin',
            'expire' => 'Expire',
            'status' => 'Status',
            'city' => '所在城市',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
            }
            return true;
        }else{
            return false;
        }
    }

    public function getText()
    {
        return $this->hasOne(OtherText::className(), ['tid' => 'tid']);
    }
}
