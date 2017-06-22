<?php

namespace backend\modules\vip\controllers;

use Yii;
use backend\modules\vip\models\UserVipExpireDateSearch;
use backend\modules\vip\models\UserVipExpireDate;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new UserVipExpireDateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',['dataProvider'=>$dataProvider,'searchModel'=>$searchModel]);
    }

    public function actionCreate()
    {

        $model = new UserVipExpireDate();
        if ($model->load(Yii::$app->request->post())&&$model->validate()) {
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success','保存成功');
                return $this->redirect('index');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {

        $model = UserVipExpireDate::findOne($id);
        if ($model->load(Yii::$app->request->post())&&$model->validate()) {
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success','保存成功');
                return $this->redirect('index');
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = UserVipExpireDate::findOne($id);
        if ($model->delete()) {
            Yii::$app->getSession()->setFlash('danger','删除成功');
            return $this->redirect('index');
        }
    }


}
