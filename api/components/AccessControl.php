<?php

namespace app\components;

use Yii;
use yii\myhelper\Response;
use yii\base\ActionFilter;
use backend\modules\card\models\AllJurisdictionRoute;
use backend\modules\card\models\AllJurisdictionRouteChild;
use backend\modules\card\models\JurisdictionAssignment;

class AccessControl extends ActionFilter
{

    public $user_id_tag;

    public $allowActions = [];

    public function getUser()
    {
        return Yii::$app->request->headers->get($this->user_id_tag);
    }

    public function beforeAction($action)
    {
        $action = $action->getUniqueId();
        $user = $this->getUser();
        if(empty($user)){
            Response::show(404,'禁止访问',$user);
        }else{
            return self::can($action);
        }
    }

    public function can($action){
        if(in_array($action,self::getRoutes())&&!in_array($action,self::getAppRoutes())){
            if(!in_array($action,self::getAppRoutes())){
                Response::show(403,'禁止访问',$action);
            }
        }
        return true;
    }

    /**
     * @return array
     * 所有控制路由
     */
    public function getRoutes()
    {
        $cache = Yii::$app->cache;
        $key = "all_routes";
        if ($cache === null || ($routes = $cache->get($key)) === false) {
            $routes = AllJurisdictionRoute::find()->select('route')->where(['type'=>1])->asArray()->column();
            if ($cache !== null) {
                $cache->set($key, $routes,600);
            }
        }
        return $routes;
    }

    /**
     * @return array
     * 允许的路由
     */
    public function getAppRoutes(){

        $cache = Yii::$app->cache;
        $key = "allow_routes".self::getUser();
        if ($cache === null || ($routeChild = $cache->get($key)) === false) {
            $assignment = JurisdictionAssignment::find()->select('item_name')->where(['user_id'=>self::getUser()])->asArray()->column();
            $routeChild = AllJurisdictionRouteChild::find()->select('child')->where(['parent'=>$assignment])->asArray()->column();
            if ($cache !== null) {
                $cache->set($key, $routeChild,60);
            }
        }
        return $routeChild;
    }

}