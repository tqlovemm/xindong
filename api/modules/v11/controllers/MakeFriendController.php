<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/21
 * Time: 15:10
 */

namespace api\modules\v11\controllers;

use Yii;
use yii\rest\Controller;
use yii\myhelper\Easemob;
use api\modules\v11\models\User;
use yii\myhelper\Response;
use yii\myhelper\Decode;

class MakeFriendController extends Controller
{

    public $modelClass = 'api\modules\v6\models\MakeFriend';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        return parent::behaviors(); // TODO: Change the autogenerated stub
    }

    public function actions(){
        $actions = parent::actions();
        unset($actions['index'],$actions['view'],$actions['create'],$actions['update'],$actions['delete']);
        return $actions;
    }
    public function actionCreate(){
        $id = Yii::$app->request->getBodyParam('user_id');
//        $decode = new Decode();
//        if(!$decode->decodeDigit($id)){
//            Response::show(210,'参数不正确');
//        }
        $id2 = Yii::$app->request->getBodyParam('user_id2');
        $where = "id in(".$id.",".$id2.")";
        $res = User::find()->where($where)->all();
        $huanx = $this->Easemob();
        $fres = $huanx->addFriend($res[0]['username'],$res[1]['username']);
        return $fres;
        if($fres['entities']['activated']){
            Response::show('200','ok');
        }else{
            Response::show('201','失败');
        }
    }
    public function Easemob(){

        $option = [
            'client_id'  => Yii::$app->params['client_id'],
            'client_secret' => Yii::$app->params['client_secret'],
            'org_name' => Yii::$app->params['org_name'],
            'app_name' => Yii::$app->params['app_name'] ,
        ];

        $se = new Easemob($option);
        return $se;
    }

}