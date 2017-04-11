<?php

namespace frontend\modules\member\models;

use backend\modules\setting\models\MemberSorts;
use Yii;

/**
 * This is the model class for table "pre_member_sort_image".
 *
 * @property integer $id
 * @property integer $sort_id
 * @property string $img_path
 * @property integer $type
 *
 * @property MemberSorts $sort
 */
class MemberSortImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_member_sort_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort_id'], 'required'],
            [['sort_id', 'type'], 'integer'],
            [['img_path'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sort_id' => 'Sort ID',
            'img_path' => 'Img Path',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSort()
    {
        return $this->hasOne(MemberSorts::className(), ['id' => 'sort_id']);
    }
}
