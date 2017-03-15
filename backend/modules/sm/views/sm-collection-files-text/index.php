<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\sm\models\SmCollectionFilesTextSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '西蒙之家会员信息表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sm-collection-files-text-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'member_id',
                'label' => '会员编号',
                'value' => function ($data) {
                    return $data->member_id;
                }
            ],
            //'weichat',
            //'qq',
            //'cellphone',
            //'weibo',
            //'email:email',1=>'季度会员',2=>'星会员',3=>'银会员',4=>'金会员',5=>'铂金会员'
            [
                'attribute' => 'vip',
                'label' => '会员等级',
                'value' => function ($data) {
                    if($data->vip==1){
                        $vip = "季度会员";
                    }elseif($data->vip==2){
                        $vip = "星会员";
                    }elseif($data->vip==3){
                        $vip = "银会员";
                    }elseif($data->vip==4){
                        $vip = "金会员";
                    }else{
                        $vip = "铂金会员";
                    }
                    return $data->vip.' — '.$vip;
                }
            ],
             'address',
            // 'birthday',
            // 'sex',
            // 'height',
            // 'weight',
            // 'marry',
            // 'job',
            // 'hobby',
            // 'car_type',
            // 'extra',
            // 'created_at',
            // 'updated_at',
            [
                'attribute' => '发送的链接',
                'label' => '二维码',
                'value' => function ($data) {
                    return "http://13loveme.com/sm?id=$data->flag";
                }
            ],
            [
                'attribute' => 'status',
                'format'=>'raw',
                'label' => '填写状态',
                'value' => function ($data) {
                    $result = $data->status==0?"未填写":"已经填写";
                    return $data->status.' — '.$result;
                }
            ],
             //'status',
            // 'often_go',
            // 'annual_salary',



            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
