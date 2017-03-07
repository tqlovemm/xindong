<?php
namespace backend\modules\flop\models;

use Yii;

/**
 * This is the model class for table "{{%flop_content_data}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $content
 * @property string $priority
 * @property string $flag
 */
class FlopContentData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%flop_content_data}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['content','priority','flag'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getPhoto($id){


        return FlopContent::find()->select('path')->where('id=:id',[':id'=>$id])->one()->path;

    }
    public function getNumber($id){


        return FlopContent::find()->select('number,area')->where('id=:id',[':id'=>$id])->one()->number;

    }
    public function getArea($id){


        return FlopContent::find()->select('number,area')->where('id=:id',[':id'=>$id])->one()->area;

    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => 'User ID',
            'content' => '喜欢',
            'priority' => '翻牌',
            'flag' => '唯一标示',
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),

        ];
    }
}
