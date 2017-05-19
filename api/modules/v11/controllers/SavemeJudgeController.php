<?php
namespace api\modules\v11\controllers;

use yii\rest\ActiveController;
use yii\filters\RateLimiter;
use yii\helpers\Response;
use yii\db\Query;

class SavemeJudgeController extends ActiveController {
    public $modelClass = 'api\modules\v11\models\Saveme';
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::className(),
            'enableRateLimitHeaders' => true,
        ];
        return $behaviors;
    }

    public function actions() {
        $action = parent::actions();
        unset($action['index'], $action['view'], $action['create'], $action['update'], $action['delete']);
        return $action;
    }

    public function actionIndex()
    {
        $query = (new Query())->select('address')->from('{{%saveme}}')->where(['status'=>1])->orderBy('created_at desc')->groupBy('address')->all();
        $new = '';
        for($i=1;$i<count($query);$i++){
            $arr = explode(" ",$query[$i]['address']);
            $addressarr[] = $arr[0];
        }
        $addressarr = array_unique($addressarr);
        foreach($addressarr as $v){
            $new .=  $v.",";
        }
        $newarr['str'] = substr($new,0,-1);
        return $newarr;
    }

    public function actionView($id) {
        $saveme = (new Query())->select('created_id,end_time,status')->from('{{%saveme}}')->where(['created_id'=>$id])->orderBy('created_at desc')->one();
        $time = time();
        if ($saveme['status'] != 2 && $saveme['end_time'] > $time) {
            Response::show('201','2',"2");
        }
        Response::show('200','1',"1");
    }
}

