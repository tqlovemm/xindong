<?php

namespace backend\modules\male\controllers;

use backend\modules\male\models\MaleInfoText;
use common\models\Province;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate(){

        $model = new MaleInfoText();
        $province = ArrayHelper::map(Province::find()->orderBy('prov_py asc')->asArray()->all(),'prov_name','prov_name');
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if($model->save()){
                    return $this->redirect(['update','id'=>$model->id]);
                }
            }
        }

        return $this->render('create', [

            'model' => $model,'province'=>$province,
        ]);
    }

    public function actionUpdate($id){
        $model = $this->findModel($id);
        $province = ArrayHelper::map(Province::find()->orderBy('prov_py asc')->asArray()->all(),'prov_name','prov_name');
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if($model->update()){
                    return $this->render('update', [
                        'model' => $model,'province'=>$province,'link'=> $model->flag
                    ]);
                }
            }
        }

        return $this->render('update', [

            'model' => $model,'province'=>$province,
        ]);


    }

    /**
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = MaleInfoText::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
