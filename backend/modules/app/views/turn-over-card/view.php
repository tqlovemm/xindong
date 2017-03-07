<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\app\models\TurnOverCard */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Turn Over Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turn-over-card-view">

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
            'turn_over_time:datetime',
            'send',
            'flag',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
