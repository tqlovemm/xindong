<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/4
 * Time: 14:09
 */

namespace backend\modules\dating\controllers;

use backend\components\AddRecord;
use backend\modules\dating\models\DatingSignup;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\db\Query;
use yii\data\Pagination;
class DatingOtherController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'view','dating-hide', 'dating-back', 'index','delete','date-avatar','avatar','t'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(){

        $subQuery = (new Query())->select('like_id,count("like_id") as num')->from('pre_dating_signup')->where(['status'=>0])->groupBy('like_id')->all();

        $likes = array();

        foreach ($subQuery as $item){

            if($item['num']>=10){

                array_push($likes,$item['like_id']);
            }
        }

        $query = (new Query())->select('id,title,updated_at,avatar,worth,full_time,content,url,number')->from('pre_weekly')->where(['number'=>$likes,'status'=>2])->orderBy('full_time asc');

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);

    }


    public function actionDatingBack($like_id){

        $exe = \Yii::$app->db->createCommand("update pre_dating_signup set status=1 where like_id='$like_id'")->execute();
        $data = array('妹子编号'=>$like_id,'重新开放报名'=>'重新开放报名');
        if($exe){
            $data = json_encode($data);
            $data_array = array('description'=>"重新开放妹子被报名已达10人的觅约信息，妹子编号{$like_id}",'data'=>$data,'old_data'=>'','new_data'=>'','type'=>1);
            AddRecord::record($data_array);
            return $this->redirect("index");

        }

    }

}