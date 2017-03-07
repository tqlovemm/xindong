<?php
namespace backend\modules\exciting\models;

/**
 * This is the model class for table "{{%website_content}}".
 *
 * @property string $cid
 * @property string $website_id
 * @property string $name
 * @property string $path
 * @property integer $created_at
 * @property integer $created_by
 */
class WebsiteContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%website_content}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['website_id', 'name', 'path'], 'required'],
            [['website_id', 'created_at'], 'integer'],
            [['path'], 'string', 'max' => 128],
            [['name', 'created_by'], 'string', 'max' => 32],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            $this->created_at = time();
            $this->created_by = \Yii::$app->user->identity->username;

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
            'cid' => 'CID',
            'website_id' => 'Website ID',
            'name' => 'Name',
            'path' => 'Path',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
}
