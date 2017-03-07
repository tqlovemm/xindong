<?php

namespace backend\modules\bgadmin\models;

use Yii;

/**
 * This is the model class for table "pre_smadmin_member_files".
 *
 * @property integer $id
 * @property integer $member_id
 * @property integer $text_id
 * @property string $path
 * @property string $content
 * @property string $updated_at
 * @property string $created_at
 * @property string $created_by
 * @property integer $img_type
 *
 * @property SmadminMember $member
 */
class SmadminMemberFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_smadmin_member_files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text_id', 'path', 'member_id'], 'required'],
            [['text_id', 'member_id', 'img_type'], 'integer'],
            [['path'], 'string', 'max' => 128],
            [['content'], 'string', 'max' => 256],
            [['created_by'], 'string', 'max' => 16],
            [['updated_at', 'created_at'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => 'Member Id',
            'text_id' => 'Text Id',
            'path' => 'Path',
            'type' => 'Img Type',
            'content' => 'Content',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
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
                $this->created_by = Yii::$app->user->identity->username;

            }else{

                $this->updated_at = time();
            }

            return true;
        }

        return false;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMemberText()
    {
        return $this->hasOne(SmadminMemberText::className(), ['text_id' => 'text_id']);
    }
}
