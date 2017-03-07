<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/15
 * Time: 9:40
 */

namespace backend\controllers;


use backend\components\AddRecord;
use backend\models\Jiecao;
use backend\models\JiecaoCoinOperation;
use backend\models\User;
use backend\models\WeipayRecord;
use common\components\SaveToLog;
use frontend\models\RechargeRecord;
use frontend\models\UserData;
use frontend\models\UserProfile;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\db\Query;
use yii\web\Controller;
use yii\data\Pagination;
use yii\filters\AccessControl;
use Yii;
use yii\myhelper\SystemMsg;
use yii\data\ActiveDataProvider;
class JiecaoController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','weipay-rank','rank-detail','xun-search','add','list','search','reduce','jiecao-alipay','jiecao-wxpay','ranking-list','statistics','notice'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }

    public function actionStatistics(){

        $data1 = RechargeRecord::find()->select('sum(number) as sum,created_at')->andWhere(['subject'=>3])->groupBy('created_at')->orderBy('created_at desc')->asArray();
        $data2 = RechargeRecord::find()->select('sum(number) as sum,week_time')->andWhere(['subject'=>3])->groupBy('week_time')->orderBy('week_time desc')->asArray();
        $data3 = RechargeRecord::find()->select('sum(number) as sum,mouth_time')->andWhere(['subject'=>3])->groupBy('mouth_time')->orderBy('mouth_time desc')->asArray();
        $total = RechargeRecord::find()->select('sum(number) as sum')->andWhere(['subject'=>3])->column();

        $pages1 = new Pagination(['totalCount' =>$data1->count(), 'pageSize' => '15']);
        $pages2 = new Pagination(['totalCount' =>$data2->count(), 'pageSize' => '15']);
        $pages3 = new Pagination(['totalCount' =>$data3->count(), 'pageSize' => '15']);

        $model1 = $data1->offset($pages1->offset)->limit($pages1->limit)->all();
        $model2 = $data2->offset($pages2->offset)->limit($pages2->limit)->all();
        $model3 = $data3->offset($pages3->offset)->limit($pages3->limit)->all();

        $save_coin = UserData::find()->sum('jiecao_coin');

        return $this->render('statistics',[
            'save_coin'=>$save_coin,
            'model1' => $model1,
            'model2' => $model2,
            'model3' => $model3,
            'pages1' => $pages1,
            'pages2' => $pages2,
            'pages3' => $pages3,
            'total' => $total[0],
        ]);
    }

    public function actionRankingList(){

        $query = User::find()
            ->innerJoinWith(['profile','userData'=>function($data){
                $data->orderBy('jiecao_coin asc');
                $data->where(['<','jiecao_coin',150]);
            }])
            ->where(['in','groupid',[3,4]])->andWhere('role!=1')->asArray();


        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => '30']);
        $model = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('ranking-list',[
            'model' => $model,
            'pages' => $pages,
        ]);

    }
    public function actionNotice(){

        $data = Yii::$app->request->post('notice');
        $uid = Yii::$app->request->post('uid');

        $back_url = Yii::$app->request->referrer;

        Yii::$app->db->createCommand()->insert('pre_jiecaobi_notice',['notice'=>1,'user_id'=>$uid,'result'=>$data])->execute();
        return $this->redirect($back_url);

    }

    public function actionWeipayRank(){

        $data = WeipayRecord::find()->select(["user_id,sum(total_fee) as fee,count(*) as count"])->asArray();
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->groupBy('user_id')->orderBy('fee desc')->offset($pages->offset)->limit($pages->limit)->all();

       return $this->render('weipay-rank',[
           'model' => $model,
           'pages' => $pages,
       ]);

    }

    public function actionRankDetail($user_id){

        $data = WeipayRecord::find()->where(['user_id'=>$user_id])->asArray();
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->orderBy('created_at desc')->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('rank-detail',[
            'model' => $model,
            'pages' => $pages,
        ]);

    }

    public function actionJiecaoAlipay(){

        $data = RechargeRecord::find()->andWhere(['subject'=>[1,2]]);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->orderBy('created_at desc')->all();
        $sum = RechargeRecord::find()->select("sum(number)")->where(['subject'=>1])->column();

       return $this->render('jiecao-alipay',[
           'model' => $model,
           'pages' => $pages,
           'sum'=>$sum[0],
       ]);
    }
    public function actionJiecaoWxpay(){

        $data = WeipayRecord::find()->orderBy('created_at desc');
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
        $sum = WeipayRecord::find()->select("sum(total_fee)")->column();

       return $this->render('jiecao-wxpay',[
           'model' => $model,
           'pages' => $pages,
           'sum'=>$sum[0],
       ]);
    }


    public function actionSearch(){

        $profile = new UserProfile();

        if($profile->load(Yii::$app->request->post())){

            $jiecao = UserData::getId($profile->number);

            if(!empty($jiecao)){

                return $this->render("search",['jiecao'=>$jiecao,'profile'=>$profile]);

            }else{

                Yii::$app->getSession()->setFlash('fail','查询会员不存在');
            }


        }


        return $this->render("search",['profile'=>$profile]);
    }

    public function actionList(){


        return $this->render("list");

    }

    public function actionAdd(){

        $model = new Jiecao();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {

                $user_id = UserData::getIdForNumber($model->number);
                $admin = Yii::$app->user->identity->username;
                if(!empty($user_id)){

                    Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin=jiecao_coin+$model->jiecao where user_id=$user_id")->execute();
                    Yii::$app->session->setFlash('result','添加成功！！');
                    try{
                        SaveToLog::userBgRecord("管理员{$admin}为其添加{$model->jiecao}节操币",$user_id);
                    }catch (Exception $e){
                        throw new ErrorException($e->getMessage());
                    }
                }else{

                    Yii::$app->session->setFlash('result','对不起添加失败！！查询该会员不存在！！');
                }
            }
        }

        return $this->render('add', [

            'model' => $model,

        ]);

    }


    public function actionReduce(){

        $model = new JiecaoCoinOperation();
        $profile = new UserProfile();
        $admin = Yii::$app->user->identity->username;
        if($profile->load(Yii::$app->request->post())){

            $jiecao = UserData::getId($profile->number);

            if(!empty($jiecao)){

                return $this->render("jiecao",['jiecao'=>$jiecao,'profile'=>$profile,'model'=>$model]);

            }else{

                Yii::$app->getSession()->setFlash('fail','查询会员不存在');
            }
        }

        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {

                // form inputs are valid, do something here

                $user = (new Query())->from("{{%user}}")->where(['id'=>$model->user_id])->one();

                if(empty($user)){

                    Yii::$app->getSession()->setFlash('danger','保存失败！会员不存在！');

                }else{

                    if($model->type==0){//扣除节操币

                        $query = (new Query())->select('jiecao_coin')->from("{{%user_data}}")->where(['user_id'=>$model->user_id])->one();

                        if($query['jiecao_coin']>=$model->value){

                            $operation = Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin = jiecao_coin-$model->value,frozen_jiecao_coin = frozen_jiecao_coin+$model->value where user_id=$model->user_id")->execute();

                            if($operation){
                                $model->save();
                                try{
                                    SaveToLog::userBgRecord("管理员{$admin}为其扣除{$model->value}节操币",$model->user_id);
                                }catch (Exception $e){
                                    throw new ErrorException($e->getMessage());
                                }
                                Yii::$app->getSession()->setFlash('success','保存成功');
                            }

                        }else{

                            Yii::$app->getSession()->setFlash('warning','保存失败！节操币不足！');

                        }

                    }else{//增加节操币

                        $operation = Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin = jiecao_coin+$model->value where user_id=$model->user_id")->execute();

                        if($operation){
                            $model->save();
                            Yii::$app->getSession()->setFlash('success','保存成功');
                        }

                    }

                }

            }

        }

        return $this->render('jiecao', [

            'model' => $model,
            'profile'=>$profile,

        ]);

    }

}