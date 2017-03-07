<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\dating\models\HeartWeekSlideContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '心动轮播';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="heartweek-slide-content-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="container">
        <div class="row">
            <?php foreach($model as $item):?>
                <div class="col-md-2">
                    <img class="img-responsive" src="<?= $item['path']?>">
                    <?= Html::a('编辑', ['update','id'=>$item['id']], ['class' => 'btn btn-success pull-left']) ?>
                    <?= Html::a('删除', ['delete','id'=>$item['id']], [
                        'class' => 'btn btn-danger pull-right',
                        'data-method'=>'post',
                        'data-confirm'=>'确认删除',
                    ]) ?>

                </div>
            <?php endforeach;?>
        </div>
    </div>

</div>
