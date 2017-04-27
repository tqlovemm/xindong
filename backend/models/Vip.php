<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/15
 * Time: 11:22
 */

namespace backend\models;


use yii\base\Model;

class Vip extends Model
{

    public $groupid;
    public $number;

    public function rules()
    {
        return [
            [['number', 'groupid'], 'required'],
            ['groupid','integer'],
        ];
    }


}