<?php

namespace app\modules\user\controllers;
use Yii;
use app\modules\user\models\Claims;
use common\components\BaseController;
use yii\db\Query;
use yii\web\UploadedFile;
use yii\web\Controller;

class ClaimsController extends BaseController
{



    public $layout='user';

    public function __construct($id,$module)
    {
       parent::__construct($id, $module);
    }

    public function actionIndex(){


        $model = new Claims();

        if($model->load(\Yii::$app->request->post())){

                if(!$this->actionCname($model->claims_to)){


                    return $this->refresh();

                }else{



                    $model->file = UploadedFile::getInstance($model, 'file');


                    $model->file = $model->upload();

                    $model->save();

                    return $this->redirect('/index.php/user/claims/claimss');
                }

        }else{

            return $this->render('index',['model'=>$model]);

        }

    }


    public function actionClaimss(){


       return $this->render('claims_success');

    }

    public function actionCname($user){

        $query = new Query();
        $query2=new Query();
        $query->select('username')
            ->from('{{%user}}')
            ->where(['username'=>$user]);

        $query2->select('claims_to')
            ->from('{{%user_claims}}')
            ->where(['created_by'=>\Yii::$app->user->identity->username,'claims_to'=>$user]);

        if($query->count()==0){

            echo '对不起您投诉对象不存在,请核实用户名，以免发起不必要的投诉';
            return false;

        }else{

            if($query2->count()!=0){

                echo '同一个用户在审核期内您只能投诉一次';
                return false;

            }else{

                echo '<a class="text-success">投诉用户名真实存在</a>';

                return true;

            }



        }

    }

}