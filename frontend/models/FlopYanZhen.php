<?php


namespace frontend\models;


use yii\base\Model;


class FlopYanZhen extends Model
{

    public $password;
    public function rules(){



        return [
            ['password', 'required'],
        ];


    }

    public function attributeLabels()
    {
        return [
            'password' =>'验证码',

        ];
    }



}