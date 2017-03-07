<?php
namespace backend\modules\flop\models;

use frontend\models\CollectingFilesImg;
use frontend\models\CollectingFilesText;
use Yii;

/**
 * This is the model class for table "{{%flop_content}}".
 *
 * @property string $id
 * @property string $flop_id
 * @property string $area
 * @property string $number
 * @property string $content
 * @property string $path
 * @property integer $other
 * @property string $store_name
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $is_cover
 * @property integer $like_count
 */
class FlopContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%flop_content}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['flop_id', 'area','number','created_at', 'created_by'], 'required'],
            [['flop_id', 'created_at', 'created_by', 'is_cover','other','height','weight','sex','like_count'], 'integer'],
            [['area','number'], 'string', 'max' => 100],
            [['content', 'path', 'store_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'flop_id' => Yii::t('app', 'Flop ID'),
            'area' => '地区',
            'number' => '编号',
            'content' => '内容描述',
            'like_count' => '喜欢数',
            'nope_count' => '浏览数',
            'path' => Yii::t('app', 'Path'),
            'store_name' => Yii::t('app', 'Store Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'is_cover' => '是否发布',
            'other' => '是否好评',
        ];
    }

    public function getFile()
    {
        return $this->hasOne(CollectingFilesText::className(), ['id' => 'number']);
    }

    public function getImgs()
    {
        return $this->hasMany(CollectingFilesImg::className(), ['text_id' => 'number']);
    }
}
