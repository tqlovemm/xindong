<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/16
 * Time: 18:06
 */

namespace api\modules\v6\controllers;

use yii;
use yii\db\Query;
use yii\helpers\Response;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class UserInfoController extends ActiveController
{


    public $modelClass = 'api\modules\v6\models\UserInfo';
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

    public function actionIndex(){

        $model = $this->modelClass;
        $query = $model::find()->where(['flag'=>0]);

        return new ActiveDataProvider(
            [
               'query' => $query,
                'pagination'    => [
                    'pagesize'  =>  15,
                ],
                'sort'  =>  [
                    'defaultOrder'  =>[
                        'user_id'   =>  SORT_DESC,
                    ]
                ]
            ]
        );
    }

    public function actionView($id){

        $model = $this->findModel($id);
        return $model;
    }

    public function actionDelete($id){

        $imginfo = (new Query())->select('img_url')->from('{{%user_image}}')->where(['id'=>$id])->one();
        if(!$imginfo){
            Response::show('201','该照片不存在');
        }
        $imgPath = explode(Yii::$app->params['hostname'],$imginfo['img_url']);
        $imgRealPath =  Yii::getAlias('@apiweb').$imgPath[1];
        unlink($imgRealPath);
        $res = Yii::$app->db->createCommand()->delete('pre_user_image','id=:id',array(':id'=>$id))->execute();
        if(!$res){
            Response::show('201','图片删除失败');
        }
        Response::show('200','图片删除成功',$imgRealPath);
    }

    public function actionUpdate($id){

        $model = new $this->modelClass;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $data = array();
        $da0 = array();
        $res = 0;
        if($imgs = $model->img_url){
            $img_list = explode('&',$imgs);
            if($model->flag == 1){
                //新添照片
                $oldimg0 = (new Query())->select('img_url')->from('pre_user_image')->where(['user_id'=>$id])->orderBy('updated_at desc')->one();

                $oldimg0 = explode('_',$oldimg0['img_url']);
                $i = $oldimg0[1];

                foreach($img_list as $item){
                    $path = '/uploads/user/files/';
                    $savaPath = Yii::getAlias('@apiweb').$path;
                    $imgName = $id.'_'.++$i.'_'.time().'.png';
                    $d[]=$url0 = Yii::$app->params['hostname'].$path.$imgName;
                    file_put_contents($savaPath.$imgName,base64_decode($item),FILE_USE_INCLUDE_PATH);
                    $res0 = Yii::$app->db->createCommand()->insert('{{%user_image}}',[
                        'user_id'  =>  $id,
                        'img_url'   =>  $url0,
                        'created_at'=>  strtotime('today'),
                        'updated_at'=>  time(),
                    ])->execute();
                    if(!$res0){
                        Response::show('201','照片添加失败');
                    }

                }
                Response::show('200','照片添加成功',$d);
            }else{
                //修改照片
                $id_list = explode('&',$model->user_id);
                $oldimg = (new Query())->select('id,img_url')->from('pre_user_image')->where(['user_id'=>$id])->all();
                if(!$oldimg){
                    Response::show('201','该用户没有档案照');
                }
                foreach($oldimg as $v){
                    //删除要修改照片
                    if(in_array($v['id'],$id_list)){
                        $pathName = explode(Yii::$app->params['hostname'],$v['img_url']);

                        $savepath = $realPath = Yii::getAlias('@apiweb').$pathName[1];
                        unlink($realPath);
                        foreach($img_list as $value){

                            $value = base64_decode($value);
                            $res = file_put_contents($savepath,$value,FILE_USE_INCLUDE_PATH);
                        }
                        $da0[] = $v['img_url'];
                    }
                }
            }

            //return $model::find()->where(['user_id'=>$id])->createCommand()->getRawSql();
        }

        if(!empty($model->address)){
            $data['address'] = $model->address;
        }
        if(!empty($model->mark)){
            $data['mark'] = $model->mark;
        }
        if(!empty($model->make_friend)){
            $data['make_friend'] = $model->make_friend;
        }
        if(!empty($model->height)){
            $data['height'] = $model->height;
        }
        if(!empty($model->weight)){
            $data['weight'] = $model->weight;
        }
        if(!empty($model->birthdate)){
            $data['birthdate'] = $model->birthdate;
        }
        if(!empty($model->is_marry)){
            $data['is_marry'] = $model->is_marry;
        }
        if(!empty($model->signature)){
            $data['signature'] = $model->signature;
        }

        $res1 = 0;
        if(!empty($data)){
            $res1 = Yii::$app->db->createCommand()->update('{{%user_profile}}',$data,'user_id=:id',array(':id'=>$id))->execute();
        }

        $res2 = 0;
        if(!empty($model->nickname)){
            $da['nickname'] = $model->nickname;
            $res2 = Yii::$app->db->createCommand()->update('{{%user}}',['nickname'=>$da['nickname']],'id=:id',array(':id'=>$id))->execute();
            $data['nickname'] = $da['nickname'];
        }
        if(!empty($da0) && $da0 != 0){
            $data['img_url'] = $da0;
        }
        if($res1 || $res2 || $res){

            Response::show('200','修改信息成功',$data);
        }else{
            Response::show('201','已修改或修改无效',$data);
        }

    }

    public function actionCreate(){

        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if(!$model->validate()){

            $errors = $model->errors;
            Response::show('201','参数不正确',$errors);
        }
        $user_id = $model->user_id;
        $res1 = (new Query())->from('pre_user_profile')->where(['user_id'=>$user_id])->one();
        $res0 = (new Query())->from('pre_user')->where(['id'=>$user_id])->one();
        if(!$res1 || !$res0){
            Response::show('201','用户不存在');
        }

        $birthday = $model->birthdate;
        $age = date('Y-m-d',time())-$birthday;
        if($age<18){
            Response::show('201','年龄不满18岁');
        }
        $res2 = Yii::$app->db->createCommand("update pre_user set `nickname` = '{$model->nickname}' where id={$model->user_id}")->execute();
        $res3 = Yii::$app->db->createCommand()->update('{{%user_profile}}',[

            'created_at'=>strtotime('today'),
            'updated_at'=>time(),
            'address'=>$model->address,
            'mark'=>$model->mark,
            'is_marry'=>$model->is_marry,
            'make_friend'=>$model->make_friend,
            'height'=>$model->height,
            'weight'=>$model->weight,
            'signature' =>$model->signature,
            'birthdate'=>$model->birthdate,//
        ],'user_id =:id ',array(':id'=>$user_id))->execute();
        $info = $model;
        $img = $model->img_url;
        if(!empty($img)){
            $img1 = (new Query())->select('img_url')->from('pre_user_image')->where(['user_id'=>$user_id])->all();
            if(!empty($img1)){
                $str = array(
                    'code'  =>  '201',
                    'msg'   =>  '用户档案照已上传,无需再上传',
                    'data'  =>  '',
                );
                return $str;
            }
            $data = explode('&',$img);
            $list = array();
            foreach($data as $k=>$v){
                $list[] = base64_decode($v);
            }
            $path = '/uploads/user/files/';

            $oldimg = (new Query())->from('pre_user_image')->where(['user_id'=>$user_id])->all();

            if($oldimg){
                foreach($oldimg as $v){
                    unlink(Yii::getAlias('@apiweb').$v['img_url']);
                }
            }

            $data = array();
            foreach($list as $k=>$v){

                $t = $model->user_id.'_'.$k.'_'.time();
                $path2 = $path.$t.'.png';
                $rpath = Yii::getAlias('@apiweb').$path2;
                file_put_contents($rpath,$v,FILE_USE_INCLUDE_PATH);
                $data[] = Yii::$app->params['hostname'].$path2;
            }

            //保存图片
            foreach($data as $k=>$v){
                $res4 = Yii::$app->db->createCommand()->insert('{{%user_image}}',[
                    'user_id'   =>  $model->user_id,
                    'img_url'  =>  $v,
                    'created_at'=>  strtotime('today'),
                    'updated_at'=>  time(),
                ])->execute();
                //$id =  yii::$app->db->getLastInsertID();
            }
        }
        $img2 = (new Query())->select('img_url')->from('pre_user_image')->where(['user_id'=>$model->user_id])->all();

        $info['img_url'] = $img2;
        if(($res2 && $res3) || $res4){
            $str = array(
                'code'  =>  '200',
                'msg'   =>  '更新信息成功',
                'data'  =>  $info,
            );

        }else{
            $str = array(
                'code'  =>  '200',
                'msg'   =>  '更新信息成功',
                'data'  =>  $info,
            );
        }
        return $str;
    }


    protected function findModel($id)
    {
        $modelClass = $this->modelClass;

        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new yii\web\NotFoundHttpException('The requested page does not exist.');
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