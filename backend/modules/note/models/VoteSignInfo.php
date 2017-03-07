<?php

namespace backend\modules\note\models;

use Yii;

/**
 * This is the model class for table "pre_vote_sign_info".
 *
 * @property integer $id
 * @property string $openid
 * @property string $number
 * @property string $declaration
 * @property integer $sex
 * @property string $extra
 * @property integer $vote_count
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 *
 * @property VoteSignImg[] $voteSignImgs
 */
class VoteSignInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_vote_sign_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openid'], 'required'],
            [['sex', 'vote_count', 'created_at', 'updated_at', 'status'], 'integer'],
            [['openid'], 'string', 'max' => 64],
            [['number'], 'string', 'max' => 32],
            [['declaration', 'extra'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '参赛编号',
            'openid' => 'Openid',
            'number' => '平台编号或微博号',
            'declaration' => '交友宣言',
            'sex' => '性别（0为男，1为女）',
            'extra' => '其他',
            'vote_count' => '得票数',
            'created_at' => '报名时间',
            'updated_at' => '更新时间',
            'status' => '审核状态（1等待审核，2审核通过，3审核不通过）',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVoteSignImgs()
    {
        return $this->hasMany(VoteSignImg::className(), ['info_id' => 'id']);
    }
}
