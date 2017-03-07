<?php

namespace backend\modules\note\models;

use Yii;

/**
 * This is the model class for table "pre_vote_sign_img".
 *
 * @property integer $id
 * @property integer $info_id
 * @property string $img
 * @property integer $type
 *
 * @property VoteSignInfo $info
 */
class VoteSignImg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_vote_sign_img';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['info_id', 'img'], 'required'],
            [['info_id', 'type'], 'integer'],
            [['img'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'info_id' => 'Info ID',
            'img' => 'Img',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInfo()
    {
        return $this->hasOne(VoteSignInfo::className(), ['id' => 'info_id']);
    }
}
