<?php

namespace backend\models;

use yii\base\Model;

class UserInfo extends Model
{
    public $content;
    public $type;

    public function rules()
    {
        return [

            [['content','type'], 'string'],

        ];
    }

}