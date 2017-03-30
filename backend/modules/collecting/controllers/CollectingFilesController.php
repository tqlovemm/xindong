<?php

namespace backend\modules\collecting\controllers;

use backend\components\AddRecord;
use frontend\models\CollectingSeventeenFilesImg;
use Yii;
use backend\models\CollectingFilesText;
use backend\modules\collecting\models\CollectingFilesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Collecting17FilesController implements the CRUD actions for Collecting17FilesText model.
 */
class CollectingFilesController extends Controller
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
        ];
    }

    /**
     * Lists all Collecting17FilesText models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CollectingFilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Collecting17FilesText model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $img = CollectingSeventeenFilesImg::find()->where(['text_id'=>$id])->asArray()->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'img'=>$img,
        ]);
    }

    /**
     * Creates a new Collecting17FilesText model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CollectingFilesText();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Collecting17FilesText model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $old = json_encode($model->oldAttributes);
            $new = json_encode($model->attributes);

            if($model->update()){

                $data_arr = array('description'=>"修改十七平台女会员的信息，女生会员ID：{$id}",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
                AddRecord::record($data_arr);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Collecting17FilesText model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if($model->delete()){
            $data_arr = array('description'=>"删除十七平台女会员的信息，女生会员ID：{$id}",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
            AddRecord::record($data_arr);
        }
        return $this->redirect(['index']);
    }

    public function actionDeleteImg($id)
    {
        $model = CollectingSeventeenFilesImg::findOne($id);
        if($model->delete())
        {
            $data_arr = array('description'=>"删除十七平台女会员的一张图片，女生会员ID：{$model->text_id}",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
            AddRecord::record($data_arr);
            Yii::$app->getSession()->setFlash('success','删除成功');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = CollectingFilesText::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionExcel(){

        $model = CollectingFilesText::find()->where(['status'=>[1,2]])->asArray()->all();

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("ctos")
            ->setLastModifiedBy("ctos")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(22);

        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

        //  合并
        $objPHPExcel->getActiveSheet()->mergeCells('A1:J1');

        // 表头
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '十七平台女生档案')
            ->setCellValue('A2', '序号')
            ->setCellValue('B2', '编号')
            ->setCellValue('C2', '微信号')
            ->setCellValue('D2', '手机号')
            ->setCellValue('E2', '省份')
            ->setCellValue('F2', '城市')
            ->setCellValue('G2', '身高')
            ->setCellValue('H2', '体重')
            ->setCellValue('I2', '罩杯')
            ->setCellValue('J2', '填写时间');

        for ($i = 0; $i < count($model); $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 3), $i+1);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 3), $model[$i]['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 3), $model[$i]['weichat']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 3), $model[$i]['cellphone']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 3), $model[$i]['address_province']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 3), $model[$i]['address_city']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 3), $model[$i]['height']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 3), $model[$i]['weight']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 3), $model[$i]['cup']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 3), date('Y-m-d H:i:s',$model[$i]['updated_at']));
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 3) . ':J' . ($i + 3))->getAlignment()->setVertical(5);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 3) . ':J' . ($i + 3))->getBorders()->getAllBorders()->setBorderStyle(5);
            $objPHPExcel->getActiveSheet()->getRowDimension($i + 3)->setRowHeight(16);
        }

        $objPHPExcel->getActiveSheet()->setTitle("十七平台女生档案");

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // 输出
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . '十七平台女生档案' . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        /*        $phpReader = new \PHPExcel_Reader_Excel2007();
                if (!$phpReader->canRead($filePath)) { // 这里是用Reader尝试去读文件，07不行用05，05不行就报错。注意，这里的return是Yii框架的方式。
                    $PHPReader = new \PHPExcel_Reader_Excel5();
                    if (!$PHPReader->canRead($filePath)) {
                        $errorMessage = "Can not read file.";
                        return $this->render('error', ['errorMessage' => $errorMessage]);
                    }
                }else{

                    return var_dump($phpReader->canRead($filePath));
                }*/
    }

}
