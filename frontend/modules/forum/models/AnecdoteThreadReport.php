<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/15
 * Time: 14:24
 */

namespace frontend\modules\forum\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pre_anecdote_thread_report".
 *
 * @property integer $id
 * @property integer $tid
 * @property string $by_who
 * @property string $reason
 * @property string $result
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class AnecdoteThreadReport extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%anecdote_thread_report}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tid','by_who'], 'required'],
            [['id', 'tid', 'status','created_at', 'updated_at'], 'integer'],
            [['by_who'], 'string', 'max' => 64],
            [['reason','result'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */

    public function attributeLabels()
    {
        return [
            'tid' => '帖子id',
            'by_who' => '举报者id',
            'reason' => '举报原因',
            'result' => '举报审核结果（简述审核结果）',
            'status' => '审核状态（选择：举报成功 或 举报失败）',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {

                $this->created_at = time();
                $this->updated_at = time();
            }else{
                $this->updated_at = time();
            }
            return true;
        } else {
            return false;
        }
    }

    public function getUser()
    {
        return $this->hasOne(AnecdoteUsers::className(), ['user_id' => 'by_who']);
    }

    public function getImg()
    {
        return $this->hasMany(AnecdoteThreadImages::className(), ['tid' => 'tid']);
    }
}