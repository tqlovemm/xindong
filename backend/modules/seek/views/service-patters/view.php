<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\seek\models\ServicePatters */

$this->title = $model->pid;
$this->params['breadcrumbs'][] = ['label' => 'Service Patters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-patters-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->pid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->pid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('上传图片', ['upload', 'id' => $model->pid], ['class' => 'btn btn-success'])?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'pid',
            'subject',
            'message:ntext',
            'chrono',
            'created_by',
        ],
    ]) ?>

</div>
<div class="row">
    <?php foreach ($imgs as $img):?>
    <div class="col-xs-1" style="padding: 0 5px;">
        <a class="center-block" style="margin-bottom: 5px;" href="<?=$img['pic_path']?>" data-lightbox="s" data-title="d">
            <img class="img-responsive" src="<?=$img['pic_path']?>">
        </a>
        <?= Html::a('删除', ['delete-img', 'pic_id' => $img['pic_id']], [
            'class' => 'btn-sm btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <?php endforeach;?>
</div>
