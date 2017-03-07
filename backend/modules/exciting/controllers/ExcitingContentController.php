<?php

namespace backend\modules\exciting\controllers;

use backend\components\AddRecord;
use backend\modules\exciting\models\ExcitingContent;
use Yii;
use common\components\BaseController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/*
    $old = json_encode($model->oldAttributes);
    $new = json_encode($model->attributes);

    $data_arr = array('description'=>"修改系统消息{$id}的信息",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
    AddRecord::record($data_arr);
**/

class ExcitingContentController extends BaseController
{
    public $enableCsrfValidation = false;

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
                        'actions' => ['index', 'view', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->delete()){
            $data_arr = array('description'=>"删除心动故事{$model->album_id}的一张图片{$id}",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
            AddRecord::record($data_arr);
        }
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    protected function findModel($id)
    {
        if (($model = ExcitingContent::findOne($id)) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
