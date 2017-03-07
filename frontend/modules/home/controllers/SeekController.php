<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/11
 * Time: 12:01
 */


namespace app\modules\home\controllers;
use app\modules\home\models\Album;
use common\components\BaseController;
use yii\web\NotFoundHttpException;

class SeekController extends BaseController
{
    public $layout = '@app/modules/user/views/layouts/user';

    public function actionView($id)
    {
        $model = $this->findModel($id);


        return $this->render('index', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Album::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}