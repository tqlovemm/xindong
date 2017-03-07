<?php


namespace backend\modules\flop\controllers;

use backend\components\AddRecord;
use backend\modules\flop\models\FlopContentData;
use backend\modules\flop\models\FlopContentSearch;
use Yii;
use yii\data\Pagination;
use backend\modules\flop\models\Flop;
use yii\data\SqlDataProvider;
use common\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\modules\flop\models\FlopContent;


class FlopController extends BaseController
{

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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'view', 'upload', 'index','delete','updated','save','down','flop-data','flop-data-view','flop-data-delete','flop-content-list'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $count = Yii::$app->db
            ->createCommand("SELECT count(*) FROM {{%flop}}  WHERE status=1")
            ->queryScalar();
        $dataProviders = new SqlDataProvider([
            'sql' => 'SELECT id, cover_id, status,area,content FROM {{%flop}} WHERE status=1 order by id desc',
            'totalCount' => $count,
            'pagination' => array('pageSize' => 100),
        ]);

        $searchModel = new FlopContentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviders' => $dataProviders,
        ]);



    }
    public function actionFlopData(){

        $query = FlopContentData::find()->asArray()->all();

        return $this->render('flop_data',['model'=>$query]);
    }

    public function actionFlopDataDelete($id){

        $this->findDataModel($id)->delete();

        return $this->redirect(['flop-data']);

    }

    public function actionFlopDataView($id){

        $model = $this->findDataModel($id);
        $model->content = array_filter(explode(',',$model->content));
        $model->priority = array_filter(explode(',',$model->priority));


        return $this->render('flop_data_view',[
            'model'=>$model
        ]);

    }

    public function actionFlopContentList(){

        $data = FlopContent::find();
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();

       return $this->render('flop_content',[
           'model' => $model,
           'pages' => $pages,
       ]);


    }

    public function actionDown($url){


        $content=file_get_contents($url);
        $reg="/<img.*?src=\"(.*?)\".*?>/";

        preg_match_all($reg,$content,$matches);

        $path = './imgDownload';
        if(!file_exists($path)){
            mkdir($path, 0777);
        }

        for($i = 0;$i < count($matches[1]);$i ++){

        /*explode
        $url_arr[$i] = explode('/', $matches[1][$i]);
        $last = count($url_arr[$i])-1;
        */

        //strrchr
        $filename = strrchr($matches[1][$i], '/');

        $this->downImage($matches[1][$i],$path.$filename);
        //downImage($matches[1][$i],$path.'/'.$url_arr[$i][$last]);
        }

    }

    public function downImage($url,$filename=""){


            if($url=="") return false;

            if($filename=="") {
                $ext=strrchr($url,".");
                if($ext!=".gif" && $ext!=".jpg" && $ext!=".png" && $ext!="jpeg") return false;
                $filename=date("YmdHis").$ext;
            }

            ob_start();
            //make file that output from url goes to buffer
            readfile($url);
            //file_get_contents($url);  这个方法不行的！！！只能用readfile
            $img = ob_get_contents();
            ob_end_clean();

            $fp=@fopen($filename, "a");//append
            fwrite($fp,$img);

            fclose($fp);

            return $filename;


    }
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionUpload($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $upload = $model->upload();
            if($upload){
                $data_arr = array('description'=>"为{$model->area}地区的翻牌资料增加一张档案照",'data'=>json_encode($upload),'old_data'=>'','new_data'=>'','type'=>1);
                AddRecord::record($data_arr);
            }
        }

        return $this->render('upload', [
            'model' => $this->findModel($id),

        ]);
    }

    public function actionUpdated($id){

        $query = Yii::$app->db->createCommand("select * from {{%flop_content}} where id=$id")->queryOne();
        return json_encode($query);

    }

    public function actionSave($id){

        $result = Yii::$app->db->createCommand("update {{%flop_content}} set flop_id='$_POST[flop_id]', number='$_POST[number]',height='$_POST[height]',weight='$_POST[weight]',content='$_POST[content]',other='$_POST[other]',is_cover=$_POST[is_cover],updated_at=".time()." where id=$id")->execute();

        if($result){
            echo json_encode('保存成功');
        }else{
            echo json_encode('保存失败');
        }
    }


    public function actionCreate()
    {
        $model = new Flop();

        if ($model->load(Yii::$app->request->post())&&$model->save()) {

            $data_arr = array('description'=>"创建{$model->area}地区的翻牌资料信息",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>1);
            AddRecord::record($data_arr);
            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('create', [

                'model' => $model,
            ]);
        }
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $old = json_encode($model->oldAttributes);
            $new = json_encode($model->attributes);

            if($model->update()){
                $data_arr = array('description'=>"修改翻牌区域{$model->area}的信息",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
                AddRecord::record($data_arr);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if($model->delete()){
            $data_arr = array('description'=>"删除翻牌区域{$model->area}的资料信息",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
            AddRecord::record($data_arr);
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Flop::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findDataModel($id)
    {
        if (($model = FlopContentData::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findContentModel($id)
    {
        if (($model = FlopContentData::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
