<?php

namespace api\modules\v4\controllers;

use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
class MemberSortsController extends ActiveController
{

	 public $modelClass = 'api\modules\v4\models\MemberSorts';
	/*    public $serializer = [
	        'class' => 'yii\rest\Serializer',
	        'collectionEnvelope' => 'items',
	    ];*/

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

		public function actionIndex(){

			$modelClass = $this->modelClass;
			$query = $modelClass::find();

			return new ActiveDataProvider([
				'query' => $query,
			]);

		}

     	public function actionView($id)
	    {

			$model = $this->findModel($id);

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

}