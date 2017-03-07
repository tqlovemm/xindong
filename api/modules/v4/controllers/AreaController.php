<?php

namespace api\modules\v4\controllers;

use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;

class AreaController extends ActiveController
{

 	public $modelClass = 'api\modules\v4\models\Area';

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

	public function actionIndex()
	{

			$modelClass = $this->modelClass;

			$query = $modelClass::find()->select('title as area')->groupBy('title')->where(['status'=>2,'cover_id'=>0])->asArray()->all();


			return $query;
		

	}

}