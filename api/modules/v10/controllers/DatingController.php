<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/22
 * Time: 14:26
 */

namespace api\modules\v10\controllers;


use api\modules\v5\models\User;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;

class DatingController extends Controller
{

    public $modelClass = 'api\modules\v6\models\UserDating';
    public $serializer = [
        'class'     =>  'yii\rest\Serializer',
        'collectionEnvelope' => 'items'
    ];
    public function behaviors(){

        return parent::behaviors();
    }

    public function actions(){

        $actions = parent::actions();
        unset($actions['index'],$actions['view'],$actions['update'],$actions['create'],$actions['delete']);
        return $actions;
    }

    public function actionView($id){

        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $user = User::find()->select('id,groupid,sex')->where(['id'=>$id])->one();
        $time = time();
        //一个月觅约一次
        $dating = (new Query())->select('expire,status')
            ->from('{{%app_selfdating}}')
            ->where(['user_id'=>$id,'status'=>0])
            ->andWhere("status > {$time}")
            ->count();

        if($dating){
            Response::show('201','您一个月只需发布一次觅约');
        }

        if($user['groupid'] < 2 && $user['sex'] == 0){

            Response::show('201','您的等级不够，请先升级为会员');
        }

        Response::show('200','操作成功');

    }

    public function actionIndex()
    {

        $user_id = $_GET['user_id'];
        $decode = new Decode();
        if(!$decode->decodeDigit($user_id)){
            Response::show(210,'参数不正确');
        }
        $res = (new Query())->select('sex')->from('{{%user}}')->where(['id' => $user_id])->one();

        if (!$res) {
            Response::show('201', '用户不存在');
        } else {
            if ($res['sex'] == 0) {
                $res['sex'] = 1;
            } else {
                $res['sex'] = 0;
            }

            $model = $this->modelClass;
            $time = isset($_GET['time']) ? $_GET['time'] : '';
            $age = isset($_GET['age']) ? $_GET['age'] : null;
            $marry = isset($_GET['marry']) ? $_GET['marry'] : null;
            $address = isset($_GET['address']) ? $_GET['address'] : '';

            $where = ' pre_user_profile.status = 2 and pre_user_profile.flag =2 and sex = ' . $res['sex'];

            //查询24小时内的觅约
            if (!empty($time) && $time == 1) {
                $t = time() - 86400;
                $where .= ' and updated_at > ' . $t;
            }


            if ($age !== null) {
                $ages = explode('~', $age);
                $len = count($ages);
                if ($len == 2) {
                    $sage = $ages[0];
                    $lage = $ages[1];
                    $where .=  ' and (year(now())-year(`birthdate`)) >= '.$sage.' and (year(now())-year(`birthdate`)) < '.$lage;
                } else {
                    $lage = $ages[0];
                    //查询小于等于18岁的
                    if($lage == 18 ){
                        $where .= " and (year(now())-year(`birthdate`)) <= " . $lage;
                    }elseif($lage == 30 ){
                        //查询大于等于30岁的
                        $where .= " and (year(now())-year(`birthdate`)) >= " . $lage;
                    }else{
                        Response::show('201','年龄不正确');
                    }
                }
            }

            if ($marry !== null && $marry == '单身') {
                $where .= ' and is_marry = 0';
            } elseif ($marry !== null && $marry == '有男/女朋友') {
                $where .= ' and is_marry = 1 ';
            } elseif ($marry !== null && $marry == '已婚') {
                $where .= ' and is_marry = 2';
            }

            if (!empty($address)) {

                $address = $address."%";
                $where .= ' and address like \'' . $address.'\'';
            }

            $query = $model::find()
                ->select('pre_user_profile.*,pre_user.sex,pre_user.avatar')
                ->leftJoin('{{%user}}', 'pre_user.id = pre_user_profile.user_id ')
                ->where($where);

            return new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 15,
                ],
                'sort' => [
                    'defaultOrder' =>
                        ['updated_at' => SORT_DESC,],
                ],
            ]);

        }
    }
}