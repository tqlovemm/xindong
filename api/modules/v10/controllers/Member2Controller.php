<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/22
 * Time: 17:35
 */

namespace api\modules\v10\controllers;

use Yii;
use yii\db\Query;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;

class Member2Controller extends Controller
{

    public $modelClass = 'api\modules\v5\models\Member';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        // 注销系统自带的实现方法
        unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
        return $actions;
    }

    public function actionView($id){

        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $model = new $this->modelClass();
        $userInfo = $model::findOne($id);
        $arr = array(2,3,4);

        if(!in_array($userInfo->groupid,$arr)){

            $str = array(
                'code'  =>  '201',
                'msg'   =>  '操作失败',
                'data'  =>  '用户是非会员',
                'is_status' =>  0,
            );

        }else{

            $str = array(
                'code'  =>  '200',
                'msg'   =>  '操作成功',
                'data'  =>  '用户是会员',
                'is_status' =>  0,
            );
        }
        return $str;

    }

    public function actionIndex(){

        $user_id = Yii::$app->request->get('user_id');
        $decode = new Decode();
        if(!$decode->decodeDigit($user_id)){
            Response::show(210,'参数不正确');
        }
        if(!$user_id){
            Response::show('201','参数缺失','用户编号不能为空');
        }

        $sex = (new Query())->select('sex')->from('pre_user')->where(['id'=>$user_id])->one();
        if($sex['sex'] == 1){
            $sex['sex'] = 0;
        }else{
            $sex['sex'] = 1;
        }

        $model = (new Query())->select('address as area')
            ->from('pre_user_profile as p')
            ->leftJoin('{{%user}}', 'pre_user.id = p.user_id ')
            ->where(['flag'=>2,'p.status'=>2,'sex'=>$sex])
            ->groupBy('area')->all();

        if($model){
            $list = array();
            $data['value'] = array();
            foreach($model as $v=>$k){

                array_push($data['value'],explode(' ',$k['area'])[0]);
            }
            //去除重复数组元素
            array_push($list,array_unique($data['value']));
            $row = array();
            foreach($list as $li){
                $word1 = '省';
                $word2 = '市';
                $word3 = '区';
                foreach($li as $k=>$v){

                    if($v == 'NY'){
                        $v = '纽约';
                    }
                    $li1 = strpos($v,$word1);
                    $li2 = strpos($v,$word2);
                    $li3 = strpos($v,$word3);
                    if(!$li1 && !$li2 && !$li3){
                        $row[] = $v;
                    }
                }
            }
            Response::show('200','成功',$row);
        }
    }

}