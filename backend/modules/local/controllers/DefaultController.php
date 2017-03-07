<?php

namespace backend\modules\local\controllers;

use backend\modules\sm\models\Province;
use backend\modules\local\models\LocalCollectionCount;
use backend\modules\local\models\LocalCollectionFilesText;
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

        $model = new LocalCollectionFilesText();
        $localCountModel = new LocalCollectionCount();
        $localCount = $localCountModel::find()->where(['not in','number',1])->asArray()->all();
        $local = ArrayHelper::map($localCount,'number','number_name');
        $vip = array();
        $area = ArrayHelper::map(Province::find()->orderBy('prov_py asc')->asArray()->all(),'prov_name','prov_name');

        if($model->load(Yii::$app->request->post())){

            $countModel = new LocalCollectionCount();
            $countModel = $countModel::findOne(['type'=>$model->vip]);
            $count = $countModel->count;

            $a = $model->vip;
            if($count<100&&$count>9){
                $b = "0"."$count";
            }elseif($count<10){
                $b = "00"."$count";
            }else{
                $b = $count;
            }

            $model->member_id = $a.$b;
            $model->flag = md5(time().md5(rand(10000,99999)));

            if($model->save()){
                $countModel->count += 1;
                if($countModel->update()){
                    $url = "http://13loveme.com/local?id=";
                    return $this->render('send-collecting-url',['model'=>$model,'url'=>$url]);
                }else{
                    $model::findOne($model->member_id)->delete();
                }
            }
        }
        return $this->render('_collecting_url',['model'=>$model,'areas'=>$area,'local'=>$local,'vip'=>$vip]);

    }

    public function actionLists($id)
    {
        $localCount = LocalCollectionCount::find()
            ->where(['number' => [$id,1]])
            ->count();
        $branches = LocalCollectionCount::find()
            ->where(['number' => [$id,1]])
            ->all();
        if ($localCount > 0) {
            foreach ($branches as $branche) {
                echo "<option value='" . $branche->type . "'>" . $branche->name . "</option>";
            }
        } else {
            echo "<option>-</option>";
        }
    }
}
