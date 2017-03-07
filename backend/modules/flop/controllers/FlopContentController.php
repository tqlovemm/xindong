<?php

namespace backend\modules\flop\controllers;

use backend\modules\flop\models\FlopContent;
use Yii;
use common\components\BaseController;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;



class FlopContentController extends BaseController
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
                        'actions' => ['index', 'view', 'delete','update'],
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

        $model->delete();

        return $this->redirect(Yii::$app->request->getReferrer());

    }
    public function actionUpdate(){

        $push = Yii::$app->db->createCommand()->update('{{%flop_content}}',['is_cover'=>1],1)->execute();
        $great = Yii::$app->db->createCommand()->update('{{%flop_content}}',['other'=>2],'flop_id=58')->execute();
        Yii::$app->session->setFlash('success','更新成功:'.'男生档案发布'.$push.'条，优质男生档案加入'.$great.'条');
        return $this->redirect('/index.php/flop/flop');

    }

    protected function findModel($id)
    {
        if (($model = FlopContent::findOne($id)) !== null) {
            return $model;

        } else {

            throw new NotFoundHttpException('The requested page does not exist.');

        }
    }
}
