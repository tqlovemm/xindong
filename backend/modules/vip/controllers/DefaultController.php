<?php

namespace backend\modules\vip\controllers;

use backend\modules\app\models\User;
use backend\modules\vip\models\UserVipExpireDateRecord;
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
                $query = new UserVipExpireDateRecord();
                $query->expire = $model->expire;
                $query->user_id = $model->user_id;
                $query->number = $model->number;
                $query->vip = $model->vip;
                $query->type = $model->type;
                $query->extra = "升级会员";
                $query->save();
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

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $model = UserVipExpireDate::findOne($id);
        if ($model->delete()) {
            Yii::$app->getSession()->setFlash('danger','删除成功');
            return $this->redirect('index');
        }
    }

    public function actionRenewPage($id,$reopen=0){
        $model = UserVipExpireDate::findOne($id);
        return $this->render('renew-page',['model'=>$model,'reopen'=>$reopen]);
    }

    public function actionRenew($id,$type,$expire,$reopen=0){

        $model = UserVipExpireDate::findOne($id);
        $model->expire = $expire;
        $model->type = $type;

        if($model->update()){

            if($reopen==1){
                $user = User::findOne($model->user_id);
                if(empty($user)){
                    $user = User::findOne(\backend\models\User::getId($model->number));
                    if(!empty($user)){
                        $user->groupid = $model->vip;
                        $user->update();
                    }

                }else{
                    $user->groupid = $model->vip;
                    $user->update();
                }

            }

            $query = new UserVipExpireDateRecord();
            $query->expire = $model->expire;
            $query->user_id = $model->user_id;
            $query->number = $model->number;
            $query->vip = $model->vip;
            $query->type = $model->type;
            $query->extra = "会员续费";
            $query->save();

            return $this->render('renew',['model'=>$model]);
        }


    }

}
