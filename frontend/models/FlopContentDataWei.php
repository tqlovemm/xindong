<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pre_flop_content_data_wei".
 *
 * @property integer $id
 * @property string $openid
 * @property integer $priority
 * @property string $comments_content
 * @property integer $comments_dated
 * @property integer $comments_evaluate
 * @property integer $updated_at
 * @property integer $created_at
 * @property string $flag
 * @property string $img
 * @property integer $status
 * @property integer $is_evaluate
 */
class FlopContentDataWei extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_flop_content_data_wei';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comments_dated', 'priority' ,'comments_evaluate', 'updated_at', 'created_at', 'status', 'is_evaluate'], 'integer'],
            [['openid'], 'string', 'max' => 64],
            [['comments_content'], 'string', 'max' => 512],
            [['flag','img'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->updated_at = time();
            }
            return true;
        }else{
            return false;
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'openid' => 'Openid',
            'priority' => 'Priority',
            'comments_content' => 'Comments Content',
            'comments_dated' => 'Comments Dated',
            'comments_evaluate' => 'Comments Evaluate',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'flag' => 'Flag',
            'img' => 'Img',
            'status' => 'Status',
            'is_evaluate' => 'IS Evaluate',
        ];
    }
}
