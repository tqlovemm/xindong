<?php

namespace api\modules\v9\controllers;

use api\modules\v5\models\User;
use yii;
use yii\rest\ActiveController;
use api\modules\v9\models\MemberSort;
use api\modules\v4\models\PredefinedJiecaoCoin;

class MemberSort3Controller extends ActiveController
{

    public $modelClass = 'api\modules\v6\models\Member';
    public function behaviors()
    {
        return parent::behaviors();
    }

    public function actions()
    {
        $actions =  parent::actions();
        unset($actions['index'],$actions['view'],$actions['create'],$actions['update'],$actions['delete']);
        return $actions;
    }

    public function actionView($id){

        $res = (new PredefinedJiecaoCoin())->find()->where(['type'=>1,'member_type'=>0,'status'=>10])->orderBy('money asc')->all();
        $res2 = (new yii\db\Query())->select('jiecao_coin')->from('{{%user_data}}')->where(['user_id'=>$id])->one();
        $data = array();
        $data['jiecao_coin'] = $res2['jiecao_coin'];
        array_fill_keys($data,$res2['jiecao_coin']);
        $data['member'] = $res;
        $data['is_status'] = 0; //1审核环境；0生产环境
        return $data;

    }

    public function actionIndex(){

        $uid = $_GET['uid'];
        $level = User::find()->select('groupid')->where(['id'=>$uid])->one();
        $lunbo = (new yii\db\Query())->from('{{%app_lunbo}}')->where('')->all();

        //审核状态 1 ，生产状态 0
        $status = 0;

        if($status == 1){

            $result = MemberSort::find()->where(['flag'=>[1]])->orderby(' groupid DESC ')->all();

            for($i = 0 ; $i < count($result); $i ++){
                if($i == 0){
                    $result[0]['price_1'] = 4998;
                    $result[0]['giveaway'] = 1880;
                }else if($i == 1){
                    $result[1]['price_1'] = 1998;
                    $result[1]['giveaway'] = 990;
                }
            }
        }else{

            $result = MemberSort::find()->where(['flag'=>[1,3]])->orderby(' groupid DESC ')->all();
        }

        $str = array(
            'is_status' => $status,
            'user_level'    =>  $level['groupid'],
            'member' => $result,
            'lunbo' =>  $lunbo,
        );

        return $str;
    }

    // test会员升级付费逻辑（user_id 和 member_sort.id）
    public function actionCreate($id){

        /*$sort_id = Yii::$app->request->getBodyParams("sort_id");
        $userInfo = User::find()->where(['id'=>$id])->one();
        $price1 = MemberSort::find()->where(['groupid'=>$userInfo['groupid'],'flag'=>[1,3]])->one();
        $price2 = MemberSort::find()->where(['id'=>$sort_id])->one();

        if($userInfo['groupid'] == 1){

            $data['realPrice'] = $price2['price_1'];
            $data['realGiveaway'] = $price2['giveaway'];
            $data['groupid'] = $price2['groupid'];

        }elseif( $userInfo['groupid'] == 2 ){
            $data['realPrice'] = $price2['price_1']-$price1['price_1'];
            $data['realGiveaway'] = $price2['giveaway']-$price1['giveaway'];
            $data['groupid'] = $price2['groupid'];

        }elseif( $userInfo['groupid'] == 3 ){

            if( $price2['groupid'] <= 3 ){
                yii\myhelper\Response::show('201','您只能往上升级');
            }else{

                $data['realPrice'] = $price2['price_1']-$price1['price_1'];
                $data['realGiveaway'] = $price2['giveaway']-$price1['giveaway'];
                $data['groupid'] = $price2['groupid'];
            }

        }else{
            yii\myhelper\Response::show('201','已经是至尊级别，无需再升级');

        }
        return $data;*/


    }

}