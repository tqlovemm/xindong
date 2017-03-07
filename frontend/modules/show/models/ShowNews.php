<?php

namespace app\modules\show\models;

use Yii;

/**
 * This is the model class for table "pre_show_news".
 *
 * @property integer $id
 * @property string $content
 * @property string $title
 * @property string $path
 * @property string $url
 * @property integer $created_at
 * @property integer $updated_at
 */
class ShowNews extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_show_news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['content','path','title','url'], 'required'],
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['content','path','title','url'], 'string'],

        ];
    }

    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {

            if ($this->isNewRecord) {

                $this->created_at = time();
                $this->updated_at = time();
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
            'content' => 'Content',
            'title' => 'Title',
            'path' => 'Path',
            'url' => 'Url',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
