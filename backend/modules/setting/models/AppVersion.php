<?php

namespace backend\modules\setting\models;

use Yii;

/**
 * This is the model class for table "pre_app_version".
 *
 * @property integer $id
 * @property string $build
 * @property string $version
 * @property string $app_name
 * @property string $platform
 * @property string $update_info
 * @property string $url
 * @property integer $is_force_update
 */
class AppVersion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_app_version';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['build', 'version', 'app_name', 'platform', 'update_info', 'url', 'is_force_update'], 'required'],
            [['is_force_update'], 'integer'],
            [['build', 'version', 'app_name', 'platform', 'update_info', 'url'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'build' => 'Build',
            'version' => 'Version',
            'app_name' => 'App Name',
            'platform' => 'Platform',
            'update_info' => 'Update Info',
            'url' => 'Url',
            'is_force_update' => 'Is Force Update',
        ];
    }
}
