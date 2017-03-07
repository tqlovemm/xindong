<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pre_flop_content_data".
 *
 * @property integer $id
 * @property string $content
 * @property integer $created_at
 * @property string $flag
 */
class FlopContentData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_flop_content_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'flag'], 'required'],
            [['created_at'], 'integer'],
            [['content'], 'string', 'max' => 250],
            [['flag'], 'string', 'max' => 125]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'created_at' => 'Created At',
            'flag' => 'Flag',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {

                $this->created_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
