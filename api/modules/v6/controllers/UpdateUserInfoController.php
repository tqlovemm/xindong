<?php

namespace api\modules\v6\controllers;
use yii;
use yii\db\Query;
use yii\helpers\Response;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use api\modules\v6\models\UserInfoImg;
use api\modules\v6\models\UserInfo;

class UpdateUserInfoController extends ActiveController
{

    public $modelClass = 'api\modules\v6\models\UpdateUserInfo';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        return parent::behaviors();
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'],$actions['view'],$actions['update'],$actions['create'],$actions['delete']);
        return $actions;
    }

    protected function DealImg($img){

        $img = base64_decode($img);
        return $img;
    }

    protected function UserInfo($id){

        $model = UserInfo::find();

        return $model;
    }

    public function actionIndex(){

        $modelClass = $this->modelClass;
        $query = $modelClass::find();
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    public function actionView($id){

        $model = $this->findModel($id);
        if(isset($_GET['uid'])){
            $uid = $_GET['uid'];
            $user = (new Query())->select('id')->from('pre_user')->where(['username'=>$id])->one();
            $follow = Yii::$app->db->createCommand('select * from {{%user_follow}} WHERE user_id='.$uid.' and people_id='.$user['id'])->queryOne();
            if(!empty($follow)){
                $follow['follow'] = 1;
                unset($follow['id'],$follow['people_id']);
            }else{

                $follow['follow'] = 0;
            }

        }else{

            $follow = array();
        }

        $credit = (new Query())->select("levels,viscosity,lan_skills,sex_skills,appearance")->from("{{%credit_value}}")->where(['user_id'=>$model['id']])->one();

        if(empty($credit)){

            Yii::$app->db->createCommand()->insert('{{%credit_value}}',[
                'user_id'=>$model['id'],
                'created_at'=>time(),
                'updated_at'=>time()
            ])->execute();

            $glamorous = 600;

        }else{

            $glamorous = array_sum($credit);
        }

        $user_id = $model['id'];
        $data = Yii::$app->db->createCommand('select * from {{%user_data}} WHERE user_id='.$model['id'])->queryOne();
        $profile = Yii::$app->db->createCommand('select *,description as self_introduction from {{%user_profile}} WHERE user_id='.$model['id'])->queryOne();
        unset($model['password_hash'],$profile['description'],$model['auth_key'],$model['password_reset_token'],$model['avatarid'],$model['avatartemp'],$model['id'],$model['role'],$model['identity']);
        $profile['mark']=json_decode($profile['mark']);
        $profile['make_friend']=json_decode($profile['make_friend']);
        $profile['hobby']=json_decode($profile['hobby']);
        $profile['glamorous'] = $glamorous;
        if(!$profile['worth']){
            $profile['worth'] = 50;
        }

        $photos = Yii::$app->db->createCommand('select img_url from {{%user_image}} WHERE user_id='.$user_id)->queryAll();
        $imgs = array();
        if(!$photos){
            $imgs['photos'] = null;
        }else{
            foreach($photos as $list){

                $imgs['photos'][] = $list['img_url'];
            }
        }
        return $model+$data+$profile+$follow+$imgs;

    }

    public function actionUpdate($id){

        $model = $this->findModels($id);
        $model->load(Yii::$app->getRequest()->getBodyParams(),'');
        $res1 = (new Query())->from('pre_user_profile')->where(['user_id'=>$id])->one();
        $res0 = (new Query())->from('pre_user')->where(['id'=>$id])->one();
        if(!$res1 || !$res0){
            Response::show('201','用户不存在');
        }

        if($model->img_url){

            $data = explode('&',$model->img_url);
            //删除旧照片
            $imgs = (new Query())->select('id,img_url')->from('{{%user_image}}')->where(['user_id'=>$id])->all();
            $len1 = count($imgs);
            $newlen = count($data);

            if($imgs) {
                //删除旧照片
                $ids = array();
                foreach ($imgs as $v) {
                    $ids[] = $v['id'];
                    $imgUrl = explode(Yii::$app->params['hostname'], $v['img_url']);
                    $realUrl = Yii::getAlias('@apiweb') . $imgUrl[1];
                    unlink($realUrl);
                }

                //必须将旧图片id合并到$data中才能避免bug
                for($i = 0; $i < count($data); $i++){
                    if($i < $len1){
                        $data[$i] = $data[$i].'&'.$ids[$i];
                    }
                }
                //如果上传的少于现有的，删除数据库中多余的图片记录
                if($newlen < $len1){
                    for($i =0 ; $i<$newlen ; $i++)
                    {
                        unset($ids[$i]);
                    }

                    $ids = implode(',',$ids);
                    Yii::$app->db->createCommand('delete from pre_user_image where id in ('.$ids.')')->execute();
                }

                //删除数据库旧图片并更新图片
                foreach($data as $k=>$list){
                    $list = explode('&',$list);
                    $img = $this->DealImg($list[0]);
                    $path = '/uploads/user/files/';
                    $savePath = Yii::getAlias('@apiweb').$path;
                    $Name = $id.'_'.$k."_".time().'.png';

                    if(isset($list[1])){
                        $url = $list[1];
                    }else{
                        $url = null;
                    }
                    $saveName = $savePath.$Name;
                    $image[] = $list[0];
                    $data1['user_id'] = $id;
                    $data1['img_url'] = Yii::$app->params['hostname'].$path.$Name;
                    $data1['id'] = $url;
                    $data1['created_at'] = strtotime('today');
                    $data1['updated_at'] = time();
                    if($data1['id'] != null){

                        $res2 = Yii::$app->db->createCommand()->update('{{%user_image}}',[
                            'user_id'=>$data1['user_id'],
                            'img_url'=>$data1['img_url'],
                            'created_at'=>$data1['created_at'],
                            'updated_at'=>$data1['updated_at'],
                        ],'id=:id',[':id'=>$data1['id']])->execute();
                        if(!$res2){
                            Response::show('201','修改图片失败');
                        }

                    }else{
                        unset($data1['id']);
                        $res = Yii::$app->db->createCommand()->insert('{{%user_image}}',$data1)->execute();
                        if(!$res){
                            Response::show('201','添加图片失败');
                        }
                    }
                    file_put_contents($saveName,$img,FILE_USE_INCLUDE_PATH);
                }
            }else{
                //添加照片
                foreach($data as $k=>$list){
                    $img = $this->DealImg($list);
                    $path = '/uploads/user/files/';
                    $savePath = Yii::getAlias('@apiweb').$path;
                    $saveName = $id.'_'.$k."_".time().'.png';
                    $url = Yii::$app->params['hostname'].$path.$saveName;
                    $data2[$k]['user_id'] = $id;
                    $data2[$k]['img_url'] = $url;
                    $data2[$k]['created_at'] = strtotime('today');
                    $data2[$k]['updated_at'] = time();
                    file_put_contents($savePath.$saveName,$img,FILE_USE_INCLUDE_PATH);
                }
                foreach($data2 as $list){
                    $res = Yii::$app->db->createCommand()->insert('{{%user_image}}',$list)->execute();
                    if(!$res){
                        Response::show('201','新添加图片失败');
                    }
                }
            }
        }

        if($model->is_marry == '单身'){
            $model->is_marry = 0;
        }elseif($model->is_marry == '有男/女朋友'){
            $model->is_marry = 1;
        }elseif($model->is_marry == '已婚'){
            $model->is_marry = 2;
        }
        $model->img_url = '';
        if(!$model->update()){
            return array_values($model->getFirstErrors())[0];
        }else{
            //Yii::$app->db->createCommand('update pre_user_profile set flag = 1 where user_id = '.$id)->execute();
            Response::show('200','更新成功');
        }
    }

    protected function findModel($id)
    {
        $modelClass = $this->modelClass;

        $model = $modelClass::find()->from('pre_user')->where(['username' => $id])->asArray()->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModels($id)
    {
        $modelClass = $this->modelClass;
        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}