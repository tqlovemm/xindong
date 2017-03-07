<?php

namespace frontend\models;

use yii\base\Model;

class Encryption extends Model
{
    public $password;
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password','in','range' => [13,]],
        ];
    }

    public function sign(){

        if($this->validate()){
            return true;
        }else{
            return false;
        }

    }

}