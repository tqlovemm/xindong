<?php

namespace backend\modules\setting\models;

use Yii;

/**
 * This is the model class for table "pre_system_msg".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $file
 * @property integer $read
 * @property integer $status
 * @property integer $read_user
 */
class SystemMsg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_system_msg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content','read_user'], 'string'],
            [['created_at','user_id', 'updated_at', 'status', 'read'], 'integer'],
            [['title'], 'string', 'max' => 250],
            [['file'], 'file', 'extensions' => 'png, jpg, gif'],
        ];
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($this->isNewRecord) {

                $this->created_at = time();
                $this->updated_at = time();
                $this->read = 1;

            }

            return true;

        } else {

            return false;

        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'content' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'read' => 'Read',
            'status' => 'Status',
            'read_user' => 'Read User',
        ];
    }

    public function upload()
    {

        if ($this->validate()) {

            Yii::setAlias('@upload', '@backend/web/uploads/system/');

            $path = time().rand(999,10000) . '.' . $this->file->extension;

            $this->file->saveAs(Yii::getAlias('@upload').$path );

            return Yii::$app->request->hostInfo.'/uploads/system/'.$path;

        } else {

            return false;
        }
    }
}
