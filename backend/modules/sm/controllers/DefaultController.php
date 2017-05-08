<?php

namespace backend\modules\sm\controllers;

use backend\modules\sm\models\Province;
use backend\modules\sm\models\SmCollectionCount;
use backend\modules\sm\models\SmCollectionFilesText;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use Yii;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSendCollectionUrl(){

        $model = new SmCollectionFilesText();
        $area = ArrayHelper::map(Province::find()->orderBy('prov_py asc')->asArray()->all(),'prov_name','prov_name');

        if($model->load(Yii::$app->request->post())){

            $countModel = new SmCollectionCount();
            $countModel = $countModel::findOne(['type'=>$model->vip]);
            $count = $countModel->count;

            if($count<100){
                $b = "0"."$count";
            }else{
                $b = $count;
            }

            $model->member_id = $countModel->pre.$b;
            $model->flag = md5(time().rand(10000,99999));

            if($model->save()){
                $countModel->count += 1;
                if($countModel->update()){
                    $url = "http://13loveme.com/sm?id=";
                    return $this->render('send-collecting-url',['model'=>$model,'url'=>$url]);
                }else{
                    $model::findOne($model->member_id)->delete();
                }
            }
        }
        return $this->render('_collecting_url',['model'=>$model,'areas'=>$area]);

    }
}
