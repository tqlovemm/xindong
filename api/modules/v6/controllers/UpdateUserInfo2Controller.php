<?php

namespace api\modules\v6\controllers;
use yii;
use yii\db\Query;
use yii\helpers\Response;
use yii\rest\ActiveController;
use api\modules\v6\models\SelfDating;

class UpdateUserInfo2Controller extends ActiveController
{

    public $modelClass = 'api\modules\v6\models\UpdateUserInfo2';
    /*public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];*/

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

        $model = $this->findModel($id);
        //$model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(),'');
        $res1 = (new Query())->from('pre_user_profile')->where(['user_id'=>$id])->one();
        $res0 = (new Query())->from('pre_user')->where(['id'=>$id])->one();
        if(!$res1 || !$res0){
            Response::show('201','用户不存在');
        }

        //用户已发布觅约信息
        $info = (new Query())->select('sex,groupid,nickname,avatar')->from('{{%user}}')->where(['id'=>$id])->one();
        $address = (new Query())->select('address,status,flag')->from('{{%user_profile}}')->where(['user_id'=>$id])->one();
        $status = (new Query())->select('status,expire')->from('{{%app_selfdating}}')->where(['user_id'=>$id])->orderBy('updated_at desc')->one();

        if($address['flag'] ==2 && $address['status'] == 2 && $status['status']==0 && $status['expire'] > time()){
            Response::show('201','您已发布觅约');
        }elseif($address['flag'] ==1 && $address['status'] == 1 && $status['status']==0 && $status['expire'] > time()){
            Response::show('201','您的觅约正在审核中，一个月只需发布一次觅约');
        }

        //上传图片
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
        }else{
            Response::show('201','图片没上传');
        }

        if($model->is_marry == '单身'){
            $model->is_marry = 0;
        }elseif($model->is_marry == '有男/女朋友'){
            $model->is_marry = 1;
        }elseif($model->is_marry == '已婚'){
            $model->is_marry = 2;
        }
        $age  = date('Y',time())-$model->birthdate;
        if($age<18){
            Response::show('201','年龄小于十八岁');
        }
        $model->img_url = '';
        $model->status = 1;
        $model->user_id = $id;
        $model->dating_no = uniqid();
        $dating_no = (new Query())->select('dating_no')->from('{{%user_profile}}')->where(['dating_no'=>$model->dating_no])->one();

        if($dating_no){
            $model->dating_no = uniqid().rand(1,9);
        }

        if(!$model->save()){
            Response::show('201',array_values($model->getFirstErrors())[0]);
        }else{
            yii::$app->db->createCommand('update pre_user set nickname = \''.$model->nickname.'\' where id = '.$id)->execute();
            //一月觅约一次
            $dating = (new Query())->select('id,expire,status')->from('{{%app_selfdating}}')->where(['user_id'=>$id])->orderBy('updated_at desc')->one();

            $time = time();
            if($dating && $time<$dating['expire'] && $dating['status'] == 0){
                Response::show('201','一个月只能发布觅约一次');
            }

            $info['pay'] = 0;
            //判断会员等级 免费用户（1）：发布一次觅约交费 98元 普通用户（2）：一次免费，之后98元一次
            if($info['groupid'] == 2 && $info['sex'] == 0){
                //第二次以后觅约收取节操币
                $dating2 = (new Query())->select('id,expire,status')->from('{{%app_selfdating}}')->where(['user_id'=>$id,'status'=>0])->one();
                if($dating2 ){ // && $dating['status'] == 1
                    $jiecaocoin = $this->jiecaocoin($id);

                    if($jiecaocoin<98){
                        Response::show('201','心动币不足，请先充值');
                    }
                    //减98节操币
                    $this->DecJiecao_coin($id);
                    $info['pay'] = 98;
                }
            }elseif($info['groupid'] == 1 && $info['sex'] == 0  ){ //|| $dating['status'] == 1||!$dating

                $jiecaocoin = $this->jiecaocoin($id);
                if($jiecaocoin<98){
                    Response::show('201','心动币不足，请先充值');
                }
                //减少98节操币
                $this->DecJiecao_coin($id);
                $info['pay'] = 98;

            }
            //return $info;
            $info['expire'] = strtotime('+1 month');
            $info['created_at'] = strtotime('today');
            $info['updated_at'] = time();
            $info['level'] = $info['groupid'];
            $info['user_id'] = $id;
            $info['address'] = $address['address'];
            unset($info['groupid']);
            if($dating['status'] == 1 || $time>$dating['expire'] || !$dating){
                $res4 = yii::$app->db->createCommand()->insert('{{%app_selfdating}}',$info)->execute();
                if($res4){
                    Yii::$app->db->createCommand('update pre_user_profile set flag = 1 where user_id = '.$id)->execute();
                    Response::show('200','发布成功，等待审核');
                }else{
                    Response::show('201','发布觅约失败,请重新发布');
                }
            }else{
                Response::show('201','您已发布觅约，无需再发布');
            }
        }
    }


    public function DecJiecao_coin($id){
        $sql = 'update pre_user_data set jiecao_coin = jiecao_coin -98 where user_id = '.$id;;
        Yii::$app->db->createCommand($sql)->execute();
    }

    public function jiecaocoin($id){
        $jiecao_coin = (new Query())->select('jiecao_coin')->from('{{%user_data}}')->where(['user_id'=>$id])->one();
        return $jiecao_coin['jiecao_coin'];
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