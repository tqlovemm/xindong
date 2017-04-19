<?php

namespace frontend\modules\member\controllers;

use backend\modules\dating\models\RechargeRecord;
use common\Qiniu\QiniuUploader;
use frontend\models\UserAvatarCheck;
use frontend\models\UserProfile;
use Yii;
use yii\base\Model;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\imagine\Image;
use app\modules\user\models\User;
use app\modules\user\models\Profile;
use common\components\BaseController;
use yii\myhelper\Easemob;
class SettingController extends BaseController
{
    //public $defaultAction = 'profile';
    public $enableCsrfValidation = false;
    public $layout = '@app/themes/basic/layouts/main';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['profile', 'account', 'security', 'avatar','mark','index','avatar-update','t'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(){



        return $this->render('index');



    }

    public function actionProfile()
    {
        $model = $this->findModel();
        $profile = Profile::find()->where(['user_id' => $model->id])->one();

        if(empty($profile)){
            $profileModel = new UserProfile();
            $profileModel->user_id = $model->id;
            $profileModel->save();
        }
        $pre_url = Yii::$app->params['appimages'];

        if (Yii::$app->request->isPost && !empty($_FILES)) {

            $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);

            if(!empty($model->avatar)){
                $avatar = str_replace($pre_url,'',$model->avatar);
                try{
                    $qn->delete('appimages',$avatar);
                }catch (\Error $e){

                }
            }

            $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$model->id;
            $qiniu = $qn->upload('appimages',"uploads/user/avatar/$mkdir");

            $model->avatar = $pre_url.$qiniu['key'];

            $model->update();
        }

        if ($profile->load(Yii::$app->request->post())) {

            if($profile->save()){

                return $this->redirect('/member/user');
            }

        }

        if(!empty($profile->address_1)){

            $address_1 = json_decode($profile->address_1,true);
            $profile->address_1 = $address_1['province'].'   '.$address_1['city'];
        }
        if(!empty($profile->address_2)){

            $address_2 = json_decode($profile->address_2,true);
            $profile->address_2 = $address_2['province'].'   '.$address_2['city'];
        }
        if(!empty($profile->address_3)){

            $address_3 = json_decode($profile->address_3,true);
            $profile->address_3 = $address_3['province'].'   '.$address_3['city'];
        }


        return $this->render('profile', [
            'profile' => $profile,
            'model' => $model,
        ]);
    }

    public function actionAccount()
    {
        $model = $this->findModel();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->save()){

                return $this->redirect('/member/user');
            }
        }

        return $this->render('account', [
            'model' => $model,
        ]);
    }

    public function actionSecurity()
    {

        $model = $this->findModel();
        $model->scenario = 'security';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->setPassword($model->newPassword);
               if($model->save()){

                   return $this->redirect('/member/user');
               }
            }
        }
        return $this->render('security', [
            'model' => $model,
        ]);
    }

    protected function setMes(){

        $options = array(
            'client_id'  => 'YXA6zamAUIOdEeWcWzkZK3TkBQ',   //你的信息
            'client_secret' => 'YXA6nN7MHrOfmJi8V3viG6s9lG8IYlc',//你的信息
            'org_name' => 'thirtyone' ,//你的信息
            'app_name' => 'chatapp' ,//你的信息
        );
        $e = new Easemob($options);

        return $e;
    }

    /**
     * 选择系统头像
     */
    public function actionAvatar($name = null)
    {
        if (Yii::$app->request->isAjax) {
            if (($name = intval($name))) {
                if ($name >= 1 && $name <= 40) {
                    //删除旧头像
                    $avatar = Yii::$app->user->identity->avatar;
                    $path = Yii::getAlias('@webroot/uploads/user/avatar/') . $avatar;
                    if (file_exists($path) && (strpos($avatar, 'default') === false))
                        @unlink($path);
                    return Yii::$app->db->createCommand()->update('{{%user}}', [
                        'avatar' => Yii::$app->request->getHostInfo().'/uploads/user/avatar/default/' . $name . '.jpg',
                    ], 'id=:id', [':id' => Yii::$app->user->id])->execute();
                } else {
                    throw new HttpException(404,'The requested page does not exist.');
                }
            } else {
                return $this->renderAjax('avatar');
            }
        } else {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * @return User the loaded model
     */

    public function actionMark(){

        $model = $this->findModel();

        $profile = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();

        if(isset($_POST['Profile']['mark'])){

            if(empty($_POST['Profile']['mark'])){

                $_POST['Profile']['mark'] = Profile::getMark('mark')['mark'];

            }else{

                $_POST['Profile']['mark'] = json_encode($_POST['Profile']['mark']);
            }

        }
        if(isset($_POST['Profile']['make_friend'])){

            if(empty($_POST['Profile']['make_friend'])){

                $_POST['Profile']['make_friend'] = Profile::getMark('make_friend')['make_friend'];

            }else{

                $_POST['Profile']['make_friend'] = json_encode($_POST['Profile']['make_friend']);
            }

        }
        if(isset($_POST['Profile']['hobby'])){

            if(empty($_POST['Profile']['hobby'])){

                $_POST['Profile']['hobby'] = Profile::getMark('hobby')['hobby'];

            }else{

                $_POST['Profile']['hobby'] = json_encode($_POST['Profile']['hobby']);
            }

        }

        if ($profile->load(Yii::$app->request->post())) {

            if($profile->update()){

                return $this->redirect('/member/user');
            }
        }


        return $this->render('mark', [
            'profile' => $profile,
            'model' => $model,
        ]);

    }

    public function actionAvatarUpdate(){

        $id = Yii::$app->user->id;
        $model = Profile::findOne(['user_id'=>$id]);
        $ex = UserAvatarCheck::findOne(['user_id'=>Yii::$app->user->id]);

        if(empty($ex)){

            $user_avatar = new UserAvatarCheck();
            $user_avatar->save();
        }
        if(empty($model)){

            $user_profile = new Profile();
            $user_profile->save();
        }

        Yii::setAlias('@upload', '@webroot/uploads/dangan/');

        if (Yii::$app->request->isPost && !empty($_FILES)) {

            $extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

            if($extension=='jpeg'||$extension=='JPEG'){
                $extension='jpg';
            }
            $fileName = $model->user_id.'_'.time().rand(1,10000).'.'.$extension;

            Image::thumbnail($_FILES['file']['tmp_name'], 400, 400)->save(Yii::getAlias('@upload') . $fileName, ['quality' => 100]);

            //删除旧头像


            if(!empty($model->file_1)){

                $files = explode('/',$model->file_1);
                $file = $files[count($files)-1];
                if(file_exists("uploads/dangan/".$file))
                    @unlink("uploads/dangan/".$file);
            }


            $model->file_1 = Yii::$app->request->getHostInfo().'/uploads/dangan/'.$fileName;

            if($model->update()){

                    $ex->file = $model->file_1;
                    $ex->status = 5;
                    $ex->update();
            }
        }
        $ex = UserAvatarCheck::findOne(['user_id'=>Yii::$app->user->id]);

        return $this->render('avatar-update',['model'=>$model,'status'=>$ex->status]);
    }


    protected function findModel()
    {
        return User::findOne(Yii::$app->user->id);
    }
}
