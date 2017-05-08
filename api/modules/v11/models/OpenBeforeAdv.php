<?php
namespace api\modules\v11\models;

use app\components\db\ActiveRecord;
/**
 * This is the model class for table "pre_app_open_before_adv".
 *
 * @property integer $adv_id
 * @property string $content
 * @property string $openUrl
 * @property string $contentSize
 * @property integer $duration
 * @property integer $status
 */
class OpenBeforeAdv extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%app_open_before_adv}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adv_id', 'content','openUrl','contentSize','duration','status'], 'required'],
            [['adv_id', 'duration', 'status'], 'integer'],
            [['contentSize','openUrl','content',], 'string']
        ];
    }

    public function fields(){


        return [
            'content','openUrl','contentSize','duration'
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'adv_id' => 'Adv ID',
            'content' => 'Content',
            'openUrl' => 'OpenUrl',
            'contentSize'=>'ContentSize',
            'duration'=>'Duration',
            'status' => 'Status',
        ];
    }

}
