<?php

namespace backend\modules\sm\models;

use Yii;

/**
 * This is the model class for table "pre_province".
 *
 * @property integer $id
 * @property string $prov_id
 * @property string $prov_name
 * @property string $prov_py
 * @property string $prov_type
 * @property string $prov_state
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_province';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prov_id'], 'integer'],
            [['prov_name'], 'required'],
            [['prov_name', 'prov_py'], 'string', 'max' => 30],
            [['prov_type', 'prov_state'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prov_id' => 'Prov ID',
            'prov_name' => 'Prov Name',
            'prov_py' => 'Prov Py',
            'prov_type' => 'Prov Type',
            'prov_state' => 'Prov State',
        ];
    }
}
