<?php

namespace api\modules\v4\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\myhelper\Response;
use yii\web\NotFoundHttpException;

class ComplaintController extends ActiveController
{

 	public $modelClass = 'api\modules\v4\models\Complaint';

	public function behaviors()
	{
		$behaviors = parent::behaviors();

		return $behaviors;
	}

	public function actions()
	{
		$actions = parent::actions();
		// 注销系统自带的实现方法
		unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		return $actions;
	}
	public function actionCreate()
	{

		$model = new $this->modelClass();

		$model->load(Yii::$app->getRequest()->getBodyParams(), '');
		if (!$model->save()) {

			return array_values($model->getFirstErrors())[0];
		}

		Response::show('202','保存成功');

	}

	public function actionDelete($id)
	{
		if($this->findModel($id)->delete()){
			Response::show('202','删除成功');
		}
	}

	public function actionView($id)
	{
		$model = $this->findModels($id);
		return $model;
	}

	protected function findModel($id)
	{
		$modelClass = $this->modelClass;
		if (($model = $modelClass::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
	protected function findModels($id)
	{
		$modelClass = $this->modelClass;
		if (($model = $modelClass::findAll(['plaintiff_id'=>$id])) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}