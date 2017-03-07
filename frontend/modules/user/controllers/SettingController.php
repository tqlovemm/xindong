<?php

namespace app\modules\user\controllers;

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
    public $defaultAction = 'profile';
    public $enableCsrfValidation = false;
    public $layout = 'setting';
    
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
                        'actions' => ['profile', 'account', 'security', 'avatar','mark'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionProfile()
    {
        $model = $this->findModel();
        $profile = Profile::find()->where(['user_id' => $model->id])->one();

        //上传头像
        Yii::setAlias('@upload', '@webroot/uploads/user/avatar/');

        if (Yii::$app->request->isPost && !empty($_FILES)) {

            $extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

            if($extension=='jpeg'||$extension=='JPEG'){
                $extension='jpg';
            }
            $fileName = $model->id.'_'.time().rand(1,10000).'.'.$extension;

            Image::thumbnail($_FILES['file']['tmp_name'], 160, 160)->save(Yii::getAlias('@upload') . $fileName, ['quality' => 80]);

            //删除旧头像
            if (file_exists(Yii::getAlias('@upload').$model->avatar) && (strpos($model->avatar, 'default') === false))
                @unlink(Yii::getAlias('@upload').$model->avatar);


            $model->avatar = Yii::$app->request->getHostInfo().'/uploads/user/avatar/'.$fileName;
            $model->update();
        }

        if ($profile->load(Yii::$app->request->post()) && $profile->save()) {
            Yii::$app->getSession()->setFlash('success','保存成功');
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

                Yii::$app->getSession()->setFlash('success','保存成功');
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
                $oldPassword = $model->none;
                $model->none = md5(md5($model->newPassword).'13loveme');
                $username = Yii::$app->user->identity->username;
                $array = ['username'=>$username,'newpassword'=>$model->none];
                if ($this->setMes()->updateUser($username,$oldPassword,$array)) {
                    $model->save();
                    Yii::$app->getSession()->setFlash('success', '保存成功');
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

            $profile->update();
            Yii::$app->getSession()->setFlash('success', '保存成功');
        }


        return $this->render('mark', [
            'profile' => $profile,
            'model' => $model,
        ]);

    }
    protected function findModel()
    {
        return User::findOne(Yii::$app->user->id);
    }
}
