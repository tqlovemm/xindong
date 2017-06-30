<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\authentication\models\GirlAuthentication */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Girl Authentications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="girl-authentication-view">

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
            'video_url:url',
            'created_at',
            'updated_at',
            'status',
        ],
    ]) ?>

</div>
