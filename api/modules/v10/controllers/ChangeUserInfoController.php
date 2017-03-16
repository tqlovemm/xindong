<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/22
 * Time: 14:01
 */

namespace api\modules\v10\controllers;

use common\Qiniu\QiniuUploader;
use Yii;
use yii\db\Query;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class ChangeUserInfoController extends Controller
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

    public function actionUpdate($id){

        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $model = $this->findModels($id);
        $model->load(Yii::$app->getRequest()->getBodyParams(),'');
        $res1 = (new Query())->from('pre_user_profile')->where(['user_id'=>$id])->one();
        $res0 = (new Query())->from('pre_user')->where(['id'=>$id])->one();
        if(!$res1 || !$res0){
            Response::show('201','用户不存在');
        }
        $pre_url = Yii::$app->params['appimages'];
        //$pre_url = 'http://omu5j530t.bkt.clouddn.com/';
        if($model->img_url){

            $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
            $data = explode('&',$model->img_url);

            //删除旧照片
            $old_images = (new Query())->select('id,img_url')->from('{{%user_image}}')->where(['user_id'=>$id])->all();
            if(!empty($old_images)){

                foreach ($old_images as $oimg){
                    try{
                        $replace_img = str_replace($pre_url,'',$oimg['img_url']);
                        $qn->delete('appimages',$replace_img);
                    }catch (\Error $e){

                    }
                }
                Yii::$app->db->createCommand('delete from pre_user_image where user_id='.$id)->execute();
            }

            //保存新图片
            $pathStr = "uploads/";
            foreach ($data as $item){

                $location = $pathStr.time().rand(1,10000).'.jpg';
                file_put_contents($location,base64_decode($item));
                $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$id.'_'.md5(rand(1000,9999));
                $qiniu = $qn->upload_app('appimages','uploads/user/files/'.$mkdir,$location);
                $path = $pre_url.$qiniu['key'];
                Yii::$app->db->createCommand('insert into pre_user_image(user_id,img_url,created_at,updated_at) values('.$id.','."'$path'".','.time().','.time().')')->execute();
                @unlink($location);
            }

       /*     $len1 = count($imgs);
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
            }*/
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

            Response::show('200','更新成功');
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