<?php
namespace api\modules\v11\controllers;

use yii;
use yii\rest\ActiveController;
use yii\filters\RateLimiter;
use yii\db\Query;
use yii\myhelper\Decode;
use api\modules\v11\models\User;
use api\modules\v11\models\User2;
use yii\myhelper\Easemob;
use yii\myhelper\Response;

class GirlFlopChoiceController extends ActiveController {
    public $modelClass = 'api\modules\v11\models\GirlFlop';
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::className(),
            'enableRateLimitHeaders' => true,
        ];
        return $behaviors;
    }

    public function actions() {
        $action = parent::actions();
        unset($action['index'], $action['view'], $action['create'], $action['update'], $action['delete']);
        return $action;
    }

    public function actionView($id)
    {
//        $decode = new Decode();
//        if(!$decode->decodeDigit($id)){
//            Response::show(210,'参数不正确');
//        }
        $userInfo = User::findOne($id);
        if(!$userInfo){
            Response::show('201','用户不存在');
        }
        //环信
        $friends = $this->Easemob()->findFriend($userInfo['username']);
        if(!isset($friends['action'])){
            Response::show('201','该用户不在环信中');
        }
        $userIds = User::find()->select('id')->where(['username'=>$friends['data']])->all();
        $exceptId = array();
        foreach($userIds as $item){
            $exceptId[] = $item['id'];
        }
        $exceptId2 = implode(',',$exceptId);
        //后宫
        $flopid = array();
        $flopid2 = '';
        $model = new $this->modelClass();
        $flopres = $model::find()->select('flop_userid')->where(['user_id'=>$id])->all();
        if($flopres){
            foreach($flopres as $list){
                $flopid[] = $list['flop_userid'];
            }
            $flopid2 = implode(',',$flopid);
        }
        if($flopid2){
            $exceptId2 .= $flopid2;
        }
        $where = "sex = 0 AND img_url is not null  AND pre_user.id not in({$exceptId2})";
        $userres = User2::find()
            ->select('pre_user.id')
            ->JoinWith('image')->JoinWith('profile')->where($where)->all();
        $idarr = array();
        for($k=0;$k<count($userres);$k++){
            $idarr[] = $userres[$k]['id'];
        }
        $query = (new Query())->select('address')->from('{{%user_profile}}')->where(['status'=>1,'user_id'=>$idarr])->orderBy('created_at desc')->groupBy('address')->all();
        $new = '';
        for($i=0;$i<count($query);$i++){
            $arr = explode(" ",$query[$i]['address']);
            $addressarr[] = $arr[0];
        }
        $addressarr = array_unique($addressarr);
        foreach($addressarr as $v){
            $new[] =  $v;
        }
        return array('code'=>'200','message'=>'ok','data'=>$new);
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

