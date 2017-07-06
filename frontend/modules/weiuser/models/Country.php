<?php
namespace frontend\modules\weiuser\models;
use Yii;
/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property integer $countryID
 * @property string $country
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%new_country}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['countryID'], 'integer'],
            [['country'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'countryID' => 'Country ID',
            'country' => 'Country',
        ];
    }
}
