<?php
namespace api\modules\v11\models;

use yii\db\ActiveRecord;
/**
 * This is the model class for table "pre_app_form_thread_tag".
 *
 * @property integer $tag_id
 * @property string $tag_name
 * @property string $tag_py
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $sort
 */
class FormThreadTag extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%app_form_thread_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_name', 'tag_py'], 'required','message'=>"{attribute}不可为空"],
            [['updated_at', 'created_at', 'sort'], 'integer'],
            [['tag_name','tag_py'], 'string','max'=>64],
        ];
    }

    public function fields(){

        return [
            'tag_name',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => 'Tag Id',
            'tag_name' => 'Tag Name',
            'tag_py' => 'Tag Py',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'sort' => 'Sort',
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
            }else{
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }
}
