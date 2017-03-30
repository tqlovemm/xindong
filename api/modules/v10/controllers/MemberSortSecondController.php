<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/22
 * Time: 10:47
 */

namespace api\modules\v10\controllers;

use api\modules\v4\models\PredefinedJiecaoCoin;
use api\modules\v4\models\User;
use api\modules\v9\models\MemberSort;
use Yii;
use yii\db\Query;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;

class MemberSortSecondController extends Controller
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

        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $res = (new PredefinedJiecaoCoin())->find()->where(['type'=>1,'member_type'=>0,'status'=>10])->orderBy('money asc')->all();
        $res2 = (new Query())->select('jiecao_coin')->from('{{%user_data}}')->where(['user_id'=>$id])->one();
        $data = array();
        $data['jiecao_coin'] = $res2['jiecao_coin'];
        array_fill_keys($data,$res2['jiecao_coin']);
        $data['member'] = $res;
        $data['is_status'] = 0; //1审核环境；0生产环境
        return $data;

    }

    public function actionIndex(){

        $uid = $_GET['uid'];
        $decode = new Decode();
        if(!$decode->decodeDigit($uid)){
            Response::show(210,'参数不正确');
        }
        $level = User::find()->select('groupid')->where(['id'=>$uid])->one();
        $lunbo = (new Query())->from('{{%app_lunbo}}')->where('')->all();

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
}