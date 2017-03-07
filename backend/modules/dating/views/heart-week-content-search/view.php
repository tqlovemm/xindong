<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\recharge\models\RechargeContent */

$this->title =Html::encode(strip_tags( $model->name));
$this->params['breadcrumbs'][] = ['label' => 'Recharge Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Recharge-content-view">


    <h1><?=$this->title?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if($query==1):?>
        <?= Html::a('上传轮播图链接内容', ['upload', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('轮播图链接内容', ['/dating/heart-week-slide-content', 'id' => $model->id], ['class' => 'btn btn-instagram']) ?>
        <?php endif;?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'album_id',
            'name',
            'thumb',
            'path:image',
            'store_name',
            'created_at',
            'created_by',
            'is_cover',
        ],
    ]) ?>

</div>
