<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/22
 * Time: 15:55
 */

namespace api\modules\v10\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;

class Message2Controller extends Controller
{

    public $modelClass = 'api\modules\v7\models\Message';
    public $serializer = [
        'class' =>  'yii\rest\Serializer',
        'collectionEnvelope'    =>  'item',
    ];

    public function behaviors()
    {
        return parent::behaviors(); // TODO: Change the autogenerated stub
    }

    public function actions()
    {
        $action =  parent::actions(); // TODO: Change the autogenerated stub
        unset($action['index'],$action['view'],$action['create'],$action['update'],$action['delete']);
        return $action;
    }

    //获取帖子历史消息
    public function actionIndex(){

        $uid = isset($_GET['uid'])?$_GET['uid']:'';
        $decode = new Decode();
        if(!$decode->decodeDigit($uid)){
            Response::show(210,'参数不正确');
        }
        if(!$uid){
            Response::show('201','操作失败','参数不全');
        }

        $model = new $this->modelClass;
        $query = $model::find()
            ->join('left join','{{%app_words}} as w','pre_app_message.words_id=w.id')
            ->where(" to_id = {$uid} and from_id <> {$uid}  and is_read = 0 or (w.user_id={$uid} and to_id <> {$uid} and from_id <> {$uid})");
        //->orwhere("w.user_id={$uid}");
        return new ActiveDataProvider([
            'query' => $query,
            'pagination'    =>  [
                'pagesize'  =>  15,
            ],
            'sort'  =>  [
                'defaultOrder'  =>  [
                    'id'    =>  SORT_DESC,
                    'created_at'    =>  SORT_DESC,
                ]
            ],
        ]);
    }

}