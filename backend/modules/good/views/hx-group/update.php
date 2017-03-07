<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\HxGroup */

$this->title = 'Update Hx Group: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Hx Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="hx-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
