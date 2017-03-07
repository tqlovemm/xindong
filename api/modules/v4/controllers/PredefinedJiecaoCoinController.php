<?php

namespace api\modules\v4\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
class PredefinedJiecaoCoinController extends ActiveController
{

	 public $modelClass = 'api\modules\v4\models\PredefinedJiecaoCoin';
	  /*  public $serializer = [
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

     	public function actionIndex()
	    {

			$modelClass = $this->modelClass;
			$query = $modelClass::find()->where(['type'=>1,'status'=>10])->orderBy('money asc');
			return new ActiveDataProvider([
				'query' => $query,
			]);

	  
	    }


}