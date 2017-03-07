<?php

namespace api\modules\v4\controllers;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\helpers\Response;
class DatingSignupController extends ActiveController
{

	 public $modelClass = 'api\modules\v4\models\DatingSignup';
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

		function check($add,$area){
			foreach($add as $list){
				if(strpos($list,$area)!==false){

					return true;
				}
			}
			return false;
		}

		public function actionCreate()
		{
			  $model = new $this->modelClass();
			  $model->load(Yii::$app->getRequest()->getBodyParams(), '');

			  $ex = (new Query())->from('{{%dating_signup}}')->where(['user_id'=>$model->user_id,'like_id'=>$model->like_id])->one();
			  $full = (new Query())->from('{{%dating_signup}}')->where(['like_id'=>$model->like_id])->count();

			  $query = (new Query())->from('{{%weekly}}')->where(['number'=>$model->like_id])->one();
			  $user_info= Yii::$app->db->createCommand("select u.groupid,p.address_1,p.address_2,p.address_3 from {{%user}} as u left join {{%user_profile}} as p on p.user_id=u.id where u.id=$model->user_id")->queryOne();

				$jiecao = (new Query())->from('{{%user_data}}')->where(['user_id'=>$model->user_id])->one();

				$expire = ($query['updated_at']+$query['expire'])<time();

				$model->area =$query['title'];
				$model->worth =$query['worth'];
				$model->avatar =$query['avatar'];


				$addresses = array();
				if(!empty($user_info['address_1'])){

					$address_1 = array_values(json_decode($user_info['address_1'],true));
					$addresses = $address_1;
				}
				if(!empty($user_info['address_2'])){
					$address_2 = array_values(json_decode($user_info['address_2'],true));
					$addresses = array_merge($addresses,$address_2);
				}
				if(!empty($user_info['address_3'])){
					$address_3 = array_values(json_decode($user_info['address_3'],true));
					$addresses = array_merge($addresses,$address_3);
				}

			$query['title2'] = empty($query['title2'])?$query['title']:$query['title2'];
			$query['title3'] = empty($query['title3'])?$query['title']:$query['title3'];


				if(!empty($ex)){

					Response::show('501','保存失败','已经报名');

				}elseif($jiecao['jiecao_coin']<$query['worth']){

					Response::show('502','保存失败','节操币不足');

				}elseif(empty($query)){

					Response::show('503','保存失败','报名对象不存在');

				}elseif($full>=10){

					Response::show('504','保存失败','报名已满');

				}elseif($expire&&$user_info['groupid']==3){

					Response::show('505','保存失败',"等级不足，当前等级只可报名发布$query[expire]小时之内的妹子");

				}elseif(!$this->check($addresses,$query['title'])&&!$this->check($addresses,$query['title2'])&&!$this->check($addresses,$query['title3'])&&$user_info['groupid']==3){

					Response::show('506','保存失败','等级不足，当前等级只可报名本地区觅约');

				}else{

					if(!$model->save()) {

						return array_values($model->getFirstErrors())[0];

					}else{

						$extra = array('mark'=>$query['content'],'require'=>$query['url'],'introduction'=>$query['introduction'],'worth'=>$query['worth'],'avatar'=>$query['avatar'],'number'=>$query['number'],'address'=>$query['title']);
						$order_number = '4'.time().rand(1000,9999);
						Yii::$app->db->createCommand()->insert('{{%recharge_record}}',[
							'user_id'=>$model->user_id,
							'number'=>$query['worth'],
							'created_at'=>strtotime('today'),
							'updated_at'=>time(),
							'subject'=>3,
							'status'=>10,
							'type'=>'密约报名',
							'order_number'=>$order_number,
							'extra'=>json_encode($extra),

						])->execute();
						Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin = jiecao_coin-$query[worth] where user_id=$model->user_id")->execute();

					}

					Response::show('202','保存成功');
				}

		}
	
		public function actionUpdate($id)
		{
			/* $model = $this->findModels($id);
	 
			 $model->load(Yii::$app->getRequest()->getBodyParams(), '');
	 
			 if (!$model->save()) {
				 return array_values($model->getFirstErrors())[0];
			 }
	 
			 Response::show(202,'更新成功');*/
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