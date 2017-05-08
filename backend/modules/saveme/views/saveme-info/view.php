<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\saveme\models\SavemeInfo */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Saveme Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saveme-info-view">

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
            'saveme_id',
            'apply_uid',
            'created_at',
            'updated_at',
            'type',
            'status',
        ],
    ]) ?>

</div>
