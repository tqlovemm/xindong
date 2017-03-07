<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\exciting\models\FirefightersSignUp */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Firefighters Sign Ups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="firefighters-sign-up-view">

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
            'user_id',
            'sign_id',
            'created_at',
            'status',
        ],
    ]) ?>

</div>
