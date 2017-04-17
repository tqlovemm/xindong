<?php
namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_app_form_thread_images".
 *
 * @property integer $img_id
 * @property integer $thread_id
 * @property string $img_path
 * @property integer $img_width
 * @property integer $img_height
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $status
 */
class FormThreadImages extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%app_form_thread_images}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'img_path','img_width','img_height'], 'required'],
            [['thread_id', 'created_at', 'status','updated_at','img_width','img_height'], 'integer'],
            [['img_path'], 'string','max'=>256]
        ];
    }

    public function fields(){

        return [
            'img_id','thread_id', 'img_path','img_width','img_height'
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'img_id' => 'Img ID',
            'thread_id' => 'Thread ID',
            'img_path' => 'Img Path',
            'img_width' => 'Img Width',
            'img_height' => 'Img Height',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }

}
