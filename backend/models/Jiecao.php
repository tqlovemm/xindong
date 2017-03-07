<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/15
 * Time: 11:22
 */

namespace backend\models;


use yii\base\Model;

class Jiecao extends Model
{

    public $number;
    public $jiecao;

    public function rules()
    {
        return [

            [['number', 'jiecao'], 'required'],
            ['jiecao','integer'],

        ];
    }




}