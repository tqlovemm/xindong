<?php
namespace api\modules\v6\controllers;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/15
 * Time: 10:30
 */
use Faker\Provider\id_ID\Address;
use yii;
use yii\db\Query;
use yii\helpers\Response;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class MemberInfoController extends ActiveController
{

    public $modelClass = 'api\modules\v6\models\MemberInfo';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' =>
            'items',


    ];
    public function behaviors()
    {
        return parent::behaviors(); // TODO: Change the autogenerated stub
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'],$actions['view'],$actions['create'],$actions['update'],$actions['delete']);
        return $actions;
    }

    protected function strToTime($age){

        $age = strtotime(date('Y',time())-$age);
        return $age;
    }

    public function actionIndex(){

        $model = $this->modelClass;
        $get = Yii::$app->request->get();

        $user_id = $get['user_id']?$get['user_id']:'';
        if(!$user_id){
            Response::show('201','没有传入用户id');
        }

        //根据觅约时间    1:24小时内，0：不限
        $time = isset($get['time'])?$get['time']:'';

        //根据年龄筛选
        $sage = isset($get['sage'])?$get['sage']:'';
        if($sage){
            $sage = $this->strToTime($sage);
        }
        $lage = isset($get['lage'])?$get['lage']:'';
        if($lage){
            $lage =  $this->strToTime($lage);
        }

        //根据地区筛选
        $address = isset($get['address'])?$get['address']:'';
        //return $address;
        //根据情感状态筛选
        $marry = isset($get['marry'])?$get['marry']:null;

        $where = '1+1'.' and status = 2 ';

        //会员权限
        /*$info = (new Query())->from('pre_user')->where(['id'=>$user_id])->one();
        if(!$info){
            Response::show('201','用户不存在');
        }*/
        /*$level = array(3,4); //|| !empty($lage) ||!empty($address) ||($marry !== null && $marry < 2) && (!empty($sage))
        if(!in_array($info['groupid'],$level)) {
            Response::show('201', '等级不够，请先升级');
        }*/

        if(!empty($sage) && !empty($lage)){
            $where .= ' and `age` between '.$lage.' and '.$sage;
        }elseif(!empty($lage)){
            $where .= ' and `age` > '.$lage;
        }

        if(!empty($address)){
            $where .= ' and `address` = \''.$address.'\'';
        }

        if($marry !== null && $marry < 2){
            $where .= ' and `marry` = '.$marry;
        }
        //return $where;
        //觅约24小时内的女生&& in_array($info['groupid'],$level)&& $info['groupid'] == 4
        if($time == 1 ){
            $t = time()-86400;
            $where .= ' and `updated_at` > '.$t;
        }

        //return $where;
        $query = $model::find()->where($where);
        //return $model::find()->where($where)->createCommand()->getRawSql();
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' =>
                    ['id'    =>  SORT_DESC,],
                    //'created_at' => SORT_DESC,
                    //'title' => SORT_ASC,

            ],

        ]);


    }

    public function actionView($id){

        $query = $this->findModel($id);
        if( !empty($query->id)){
            $data = array(
                'id'=>$query->id,
                'age'   =>  $query->age,
                'marry'   =>  $query->marry,
                'address'   =>  $query->address,
                'weichat'   =>  $query->weichat,
                'cellphone'   =>  $query->cellphone,
                'weibo'   =>  $query->weibo,
                'sex'   =>  $query->sex,
                'height'   =>  $query->height,
                'weight'   =>  $query->weight,
                'job'   =>  $query->job,
                'hobby'   =>  $query->hobby,
                'like_type'   =>  $query->like_type,
                'car_type'   =>  $query->car_type,
                'extra'   =>  $query->extra,
                'flag'   =>  $query->flag,
                'status'   =>  $query->status,
                'often_go'   =>  $query->often_go,
                'annual_salary'   =>  $query->annual_salary,
                'qq'   =>  $query->qq,
                'imgs'=>$query->imgs,/**/
            );
            Response::show(200,'查询成功',$data);
        }else{
            Response::show(201,'查询失败');
        }

    }

    //收集用户信息和修改用户信息
    public function actionCreate(){

        $model = new $this->modelClass();
    }

    protected function findModel($id){


        $modelClass = $this->modelClass;

        if (($model = $modelClass::findOne(['id'=>$id]))!== null) {
            return $model;
        } else {
            //throw new NotFoundHttpException('The requested page does not exist.');
            $str = array(
                'code'  =>  201,
                'msg'   =>  'error',
                'data'  =>  '',
            );
            return $str;
        }


    }
    protected function findModels($id){

        $modelClass = $this->modelClass;

        if (($model = $modelClass::find()->where(['id'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}