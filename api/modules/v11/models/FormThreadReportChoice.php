<?php
namespace api\modules\v11\models;

use app\components\db\ActiveRecord;
/**
 * This is the model class for table "pre_app_form_thread_report_choice".
 *
 * @property integer $report_id
 * @property string $content
 * @property integer $sort
 */
class FormThreadReportChoice extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%app_form_thread_report_choice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content','report_id','sort'], 'required','message'=>"{attribute}不可为空"],
            [['report_id', 'sort'], 'integer'],
            [['content'], 'string','max'=>64],
        ];
    }

    public function fields(){

        return [
            'report_id','content'
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'report_id' => 'Report ID',
            'content'=>'Content',
            'sort' => 'Sort',
        ];
    }
}
