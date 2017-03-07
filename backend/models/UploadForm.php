<?php

namespace backend\models;

use yii\base\Model;

class UploadForm extends Model
{
    public $file;
    public $extra;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'],'required'],
            [['file'], 'file', 'extensions' => 'gif, jpg, png, bmp, jpeg'],
            [['extra'], 'string'],
        ];
    }

}
