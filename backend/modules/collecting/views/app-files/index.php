<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'App Files';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thirth-files-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(in_array(Yii::$app->user->id,[13921,10184])):?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'address',
            [
                'format' => 'raw',
                'label' => '发送给会员的表单',
                'value' => function ($data) {
                    return 'www.13loveme.com/files/'.$data->flag;
                }

            ],
            [
                'format' => 'raw',
                'label' => '填写情况',
                'value' => function ($data) {
                    if($data->status==0){
                        return '<span style="color:red;">没有填写表单</span>';
                    }elseif($data->status==2){
                        return '已填写表单，审核通过';
                    }elseif($data->status==1){
                        return '<span style="color:green;">已填写表单，审核中</span>';
                    }else{
                        return '<span style="color:blue;">审核未通过，会员修改中</span>';
                    }

                }

            ],
            'status',


            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
        ],
    ]); ?>

    <?php elseif(in_array(Yii::$app->user->id,[10174])):?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'address',
                [
                    'format' => 'raw',
                    'label' => '发送给会员的表单',
                    'value' => function ($data) {
                        return 'www.13loveme.com/files/'.$data->flag;
                    }

                ],
                [
                    'format' => 'raw',
                    'label' => '填写情况',
                    'value' => function ($data) {
                        if($data->status==0){
                            return '<span style="color:red;">没有填写表单</span>';
                        }elseif($data->status==2){
                            return '已填写表单，审核通过';
                        }elseif($data->status==1){
                            return '<span style="color:green;">已填写表单，审核中</span>';
                        }else{
                            return '<span style="color:blue;">审核未通过，会员修改中</span>';
                        }

                    }

                ],
                'status',


                ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],
            ],
        ]); ?>
    <?php else:?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'address',
                [
                    'format' => 'raw',
                    'label' => '发送给会员的表单',
                    'value' => function ($data) {
                        return 'www.13loveme.com/files/'.$data->flag;
                    }

                ],
                [
                    'format' => 'raw',
                    'label' => '填写情况',
                    'value' => function ($data) {
                        if($data->status==0){
                            return '<span style="color:red;">没有填写表单</span>';
                        }elseif($data->status==2){
                            return '已填写表单，审核通过';
                        }elseif($data->status==1){
                            return '<span style="color:green;">已填写表单，审核中</span>';
                        }else{
                            return '<span style="color:blue;">审核未通过，会员修改中</span>';
                        }

                    }

                ],
                'status',

                ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update} {delete}'],
            ],
        ]); ?>
    <?php endif;?>
</div>
