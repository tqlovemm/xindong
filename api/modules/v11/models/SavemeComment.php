<?php

namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_saveme_comment".
 *
 * @property string $id
 * @property string $saveme_id
 * @property string $created_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $level
 * @property string $label
 * @property string $content
 * @property integer $status
 */
class SavemeComment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_saveme_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['saveme_id', 'created_id', 'to_userid', 'level', 'label', 'content', 'status'], 'required'],
            [['saveme_id', 'created_id', 'created_at', 'updated_at', 'level', 'status'], 'integer'],
            [['label', 'content'], 'string', 'max' => 255]
        ];
    }

    public function fields(){

        return [
            'id','saveme_id', 'created_id', 'to_userid', 'created_at','updated_at', 'level', 'label', 'content', 'status'
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'saveme_id' => 'Saveme ID',
            'created_id' => '评价人id',
            'to_userid' => '被评价人id',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'level' => '星级',
            'label' => '标签',
            'content' => '内容',
            'status' => 'Status',
        ];
    }
}
