<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\member\models\DatingCuicu */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dating Cuicus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dating-cuicu-view">

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
            'ccid',
            'user_id',
            'created_at',
            'type',
        ],
    ]) ?>

</div>
