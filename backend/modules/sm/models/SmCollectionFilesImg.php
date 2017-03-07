<?php

namespace backend\modules\sm\models;

use Yii;

/**
 * This is the model class for table "pre_sm_collection_files_img".
 *
 * @property integer $img_id
 * @property string $member_id
 * @property string $img_path
 * @property string $thumb_img_path
 */
class SmCollectionFilesImg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_sm_collection_files_img';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'img_path'], 'required'],
            [['member_id'], 'string', 'max' => 32],
            [['img_path', 'thumb_img_path'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'img_id' => 'Img ID',
            'member_id' => 'Member ID',
            'img_path' => 'Img Path',
            'thumb_img_path' => 'Thumb Img Path',
        ];
    }

    public function getText()
    {
        return $this->hasOne(SmCollectionFilesText::className(), ['member_id' => 'member_id']);
    }
}
