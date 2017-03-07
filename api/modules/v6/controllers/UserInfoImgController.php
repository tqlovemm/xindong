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
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
class UserInfoImgController extends ActiveController
{


    public $modelClass = 'api\modules\v6\models\UserInfoImg';
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

    //修改用户档案照
    public function actionUpdate($id)
    {

        //$model = $this->modelClass;
        $img = Yii::$app->getRequest()->getBodyParams();

        $imgs = implode(':',$img);
        $imgs = explode('"',$imgs);
        $imgs = explode('------',$imgs['2']);

        $img_url = str_replace(array("\r","\n"),'',$imgs['0']);

        $img_url = base64_decode($img_url);

        if(!$img_url){
            $str = array(
                'code'  =>  '201',
                'msg'   =>  '图片上传失败,或没有上传',
            );
            return $str;
        }
        //删除旧图片
        $imgInfo = (new Query())->from('pre_user_image')->where(['id'=>$id])->one();
        $user_id = $imgInfo['user_id'];
        $oldimg = $imgInfo['img_url'];

        $imgname = explode(Yii::$app->params['hostname'],$oldimg);

        $imgInfo['img_url'] = Yii::getAlias('@apiweb').$imgname[1];
        unlink($imgInfo['img_url']);

        $rpath = Yii::getAlias('@apiweb').$imgname[1];
        file_put_contents($rpath,$img_url,FILE_USE_INCLUDE_PATH);

        $f_img_url = Yii::$app->params['hostname'].$imgname[1];

        $res = Yii::$app->db->createCommand()->update('{{%user_image}}',[
            'user_id'   =>  $user_id,
            'img_url'  =>  $f_img_url,
            'created_at'=>  strtotime('today'),
            'updated_at'=>  time(),
        ],['id'=>$id])->execute();

        if($res){
            $imgInfo = (new Query())->from('pre_user_image')->where(['id'=>$id])->one();
            $str = array(
                'code'  =>  '200',
                'msg'   =>  '图片更改成功',
                'data'  =>  $imgInfo,
            );

        }else{
            $str = array(
                'code'  =>  '200',
                'msg'   =>  '图片更改失败',
                'data'  =>  '',
            );
        }
        return $str;
    }

    public function actionCreate(){
        return '';
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
}