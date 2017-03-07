<?php

namespace backend\modules\bgadmin\controllers;

use backend\models\User;
use backend\modules\bgadmin\models\AdminerActiveRecord;
use backend\modules\setting\models\AuthAssignment;
use yii\data\Pagination;

class RecordController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $user_ids = AuthAssignment::find()->select('user_id')->asArray()->column();
        $admins = User::find()->where(['id'=>$user_ids])->asArray()->all();
        $data = AdminerActiveRecord::find()->where(['status'=>1])->orderBy('created_at desc');
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index',['model'=>$model,'pages'=>$pages,'admins'=>$admins]);
    }


    public function actionView($id){
        $user_ids = AuthAssignment::find()->select('user_id')->asArray()->column();
        $admins = User::find()->where(['id'=>$user_ids])->asArray()->all();
        $data = AdminerActiveRecord::find()->where(['status'=>1,'user_id'=>$id])->orderBy('created_at desc');
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index',['model'=>$model,'pages'=>$pages,'admins'=>$admins]);
    }

    public function actionUploader(){

        $id = \Yii::$app->request->post('id');
        $collecting_text = $this->findModel($id);

        $data = $collecting_text->upload();

        $html = <<<defo
        <img src=$data[path] data-id=$data[id] class="preview collecting-files-img">
defo;
        echo $html;
    }

}
