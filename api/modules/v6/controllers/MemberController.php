<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/9
 * Time: 16:25
 */

namespace api\modules\v6\controllers;

use yii;
use yii\db\Query;
use yii\rest\ActiveController;
use yii\helpers\Response;

class MemberController extends ActiveController
{
    public $modelClass = 'api\modules\v6\models\Member';

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


        $model = new $this->modelClass();
        $userInfo = $model::findOne($id);
        $arr = array(2,3,4);

        if(!in_array($userInfo->groupid,$arr)){
            //Response::show('201','操作失败',array('msg'=>'用户还不是会员','is_status'=>0));
            $str = array(
                'code'  =>  '201',
                'msg'   =>  '操作失败',
                'data'  =>  '用户是非会员',
                'is_status' =>  0,
            );

        }else{
            //Response::show('200','操作成功',array('msg'=>'用户还不是会员','is_status'=>0));
            $str = array(
                'code'  =>  '200',
                'msg'   =>  '操作成功',
                'data'  =>  '用户是会员',
                'is_status' =>  0,
            );
        }
        return $str;


    }
    protected function findModels($id)
    {
        $modelClass = $this->modelClass;
        if (($model = $modelClass::findAll(['id'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}