<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Thirth Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thirth-files-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(!in_array(Yii::$app->user->id,[13921,10184,10174])):?>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif;?>
        <?php if($model->status==1):?>
        <?= Html::a('审核通过', ['pass', 'id' => $model->id], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Are you sure you want to pass this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('审核不通过', ['no-pass', 'id' => $model->id], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Are you sure you want to no pass this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif;?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'weichat',
            'cellphone',
            'weibo',
            'address',
            'age:datetime',
            'sex',
            'height',
            'weight',
            'marry',
            'job',
            'hobby',
            'like_type',
            'car_type',
            'extra',
            'status',
            'often_go',
            'annual_salary',
            'qq',
        ],
    ]) ?>


    <div class="row">
        <?php foreach ($img as $item):?>
            <div class="col-md-2">
                <img class="img-responsive" src="http://13loveme.com/<?=$item['img']?>">
                <?php if(!in_array(Yii::$app->user->id,[13921,10184])):?>
                    <?= Html::a('Delete', ['delete-img', 'id' => $item['id']], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php endif;?>
            </div>

        <?php endforeach;?>
    </div>
</div>
