<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\collecting\models\Collecting17FilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Collecting17 Files Texts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collecting17-files-text-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                'address_province',
                'address_city',
                [
                    'format' => 'raw',
                    'label' => '发送给17会员的表单一',
                    'value' => function ($data) {
                        return 'www.13loveme.com/17-files/'.$data->flag;
                    }

                ],
                [
                    'format' => 'raw',
                    'label' => '发送给17会员的表单二',
                    'value' => function ($data) {
                        return 'www.13loveme.com/17-files/private/'.$data->flag;
                    }

                ],
                [
                    'format' => 'raw',
                    'label' => '填写情况',
                    'value' => function ($data) {
                        if($data->status==0){

                            return '<span style="color:red;">没有填写表单一</span>';
                        }elseif ($data->status==1){
                            return '已填写表单一，<span style="color:red;">未填写表单二</span>';
                        }else{

                            return '表单一二均填写完毕';
                        }

                    }

                ],
                'status',
                'created_at:datetime',

                ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update} {delete}'],
            ],
        ]); ?>
</div>
