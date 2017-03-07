<?php

namespace api\modules\v4\controllers;

use yii\helpers\ArrayHelper;
use yii\helpers\Response;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class UserController extends ActiveController
{

	 public $modelClass = 'api\modules\v4\models\User';
	    public $serializer = [
	        'class' => 'yii\rest\Serializer',
	        'collectionEnvelope' => 'items',
	    ];

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

			$data = \Yii::$app->request->get('data');

			$data = json_decode($data);

			$user_info = array();
			foreach ($data as $item){

				$query = \Yii::$app->db->createCommand("select username,nickname,avatar from {{%user}} where username='$item'")->queryOne();
                if(!empty($query)){
                    if(empty($query['nickname'])){$query['nickname'] = $item;}
                    array_push($user_info,$query);
                }else{
                    array_push($user_info,array('username'=>$item,'nickname'=>'','avatar'=>''));
                }
			}

			return $user_info;

		}
     	public function actionView($id)
	    {

			$model = new  $this->modelClass();
			$res = $model->find()->where(['cellphone'=>$id])->one();
			if($res){
				Response::show('201','该手机号已经注册');
			}else{
				Response::show('200','该手机号未被注册');
			}
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