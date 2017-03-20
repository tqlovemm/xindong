<?php

namespace backend\modules\bgadmin\controllers;

use frontend\modules\weixin\models\ScanWeimaRecord;
use Yii;
use backend\modules\bgadmin\models\ScanWeimaDetail;
use backend\modules\bgadmin\models\ScanWeimaDetailSearch;
use yii\data\Pagination;
use yii\myhelper\AccessToken;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ScanWeimaDetailController implements the CRUD actions for ScanWeimaDetail model.
 */
class ScanWeimaDetailController extends Controller
{
    public $cache;
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all ScanWeimaDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ScanWeimaDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ScanWeimaDetail model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionTj($id){

       $model = new ScanWeimaRecord();
       $data =  $model::find()->select('count(*) as count,created_at,status')->where(['scene_id'=>$id])->groupBy('created_at')->addGroupBy('status')->orderBy('created_at desc')->addOrderBy('status desc')->asArray();
       $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '40']);
       $model = $data->offset($pages->offset)->limit($pages->limit)->all();

       return $this->render('tj',[
           'model' => $model,
           'pages' => $pages,
       ]);
    }

    /**
     * Creates a new ScanWeimaDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ScanWeimaDetail();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {

                if($model->save()){
                    $access_token = $this->getAccessTokens();
                    $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
                    $qrcode = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$model->sence_id.'}}}';
                    $result = $this->http_post_data($url,$qrcode);
                    $ticket = json_decode($result[1],true)['ticket'];
                    $geter = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
                    $weima = "<img src='".$geter."'>";
                    $img = file_get_contents($geter);
                    $path = 'images/weima/'.$model->sence_id.'.jpg';
                    file_put_contents($path,$img);

                    $query = $model::findOne($model->sence_id);
                    $query->local_path = $path;
                    $query->remote_path = $geter;
                    $query->update();
                    return $this->render('create', [
                        'model' => $model,'weima'=>$weima,
                    ]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    private function getAccessTokens() {
        $this->cache = Yii::$app->cache;
        $data = $this->cache->get('access_token_js');
        if (empty($data)) {
            $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . Yii::$app->params['appid'] . "&secret=" . Yii::$app->params['appsecret'];
            $res = json_decode($this->http_get_data($token_access_url));
            $access_token = $res->access_token;
            if ($access_token) {
                $this->cache->set('access_token_js',$access_token,7000);
            }
        } else {
            $access_token = $data;
        }
        return $access_token;
    }

    /**
     * @param $url
     * @return mixed
     * get请求
     */
    protected function http_get_data($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    protected function http_post_data($url, $data_string) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($data_string))
        );
        ob_start();
        curl_exec($ch);
        if (curl_errno($ch)) {
            $this->ErrorLogger('curl falied. Error Info: '.curl_error($ch));
        }
        $return_content = ob_get_contents();
        ob_end_clean();
        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return array($return_code, $return_content);
    }
    private function ErrorLogger($errMsg){
        $logger = fopen('ErrorLog.txt', 'a+');
        fwrite($logger, date('Y-m-d H:i:s')." Error Info : ".$errMsg."\r\n");
    }

    /**
     * Updates an existing ScanWeimaDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->sence_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ScanWeimaDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ScanWeimaDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ScanWeimaDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ScanWeimaDetail::findOne($id)) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
