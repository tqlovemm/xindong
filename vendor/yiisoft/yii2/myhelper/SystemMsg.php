<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/17
 * Time: 12:00
 */

namespace yii\myhelper;


class SystemMsg
{
    public $user_id;
    public $title;
    public $content;
    public $file;
    public $status;
    public function __construct($user_id,$title,$content,$file='http://13loveme.com/images/jiecaobi.jpg',$status=3)
    {

        $this->user_id = $user_id;
        $this->title = $title;
        $this->content = $content;
        $this->file = $file;
        $this->status = $status;


        $model = new \backend\modules\setting\models\SystemMsg();

        $model->user_id = $this->user_id;
        $model->title = $this->title;
        $model->content = $this->content;
        $model->file = $this->file;
        $model->status = $this->status;

        if($model->save()){

            $result = array('msg'=>'success','code'=>202);
            return json_encode($result);

        }else{
            throw new \Error;
        }
    }
}