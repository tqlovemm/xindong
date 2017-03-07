<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\seventeen\models\SeventeenFilesText */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Seventeen Files Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seventeen-files-text-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'status',
            'weichat',
            'cellphone',
            'address_province',
            'address_city',
            'address_detail',
            'education',
            'age:datetime',
            'height',
            'weight',
            'cup',
            'job',
            'job_detail',
            'weibo',
            'id_number',
            'pay',
            'qq',
            'extra',
            //'sex',
            //'gotofield',
            //'created_at',
            //'updated_at',
            //'flag',

        ],
    ]) ?>

</div>
