<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Flop',
]) . ' ' . $model->area;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Flops'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->area, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="flop-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
