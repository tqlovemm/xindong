<?php
namespace app\modules\user\controllers;

use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use app\modules\forum\models\Thread;
use app\modules\user\models\User;
use common\components\BaseController;
class DashboardController extends BaseController
{
    public $layout='dashboard';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['index', 'myposts', 'myfavor', 'following', 'follower', 'forumpost', 'homepost'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {


        $model = new Thread();
        $query = new Query();
        $query->select('note')->from('{{%forum_thread}}')->where('user_id='.Yii::$app->user->id);
        $pages = Yii::$app->tools->Pagination($query);
        $result = $pages['result'];
        for($i=0,$sum=0;$i<count($result);$i++){$sum +=  $result[$i]['note'];}
        $query->select('path')->from('{{%home_photo}}')->where('created_by='.Yii::$app->user->id)->orderBy('id ASC');
        $photos = Yii::$app->tools->Pagination($query);
        $photo_num = count($photos)>3?3:count($photos);
        return $this->render('index',[
            'note_sum'=>$sum,
            '$model'=>$model->findAll(['user_id'=>Yii::$app->user->id]),
            'photo'=>$photos['result'],
            'photo_num'=>$photo_num,
        ]);
    }

    public function actionFollowing()
    {

        $this->layout = 'user';
        return $this->render('follow', [
            'title' => Yii::t('app', 'You\'re Following'),
            'type' => 'following',
            'model' => $this->findModel()
        ]);
    }

    public function actionFollower()
    {
        $this->layout = 'user';
        return $this->render('follow', [
            'title' => Yii::t('app', 'Your Followers'),
            'type' => 'follower',
            'model' => $this->findModel()
        ]);
    }

    public function actionMyfavor()
    {
        $model = $this->findModel();

        return $this->render('myfavor');
    }
    
    /**
     * Finds the User model based on its primary key value.
     * @return User the loaded model
     */
    protected function findModel()
    {
        $id = Yii::$app->user->identity->id;
        return User::findOne($id);
    }

}
