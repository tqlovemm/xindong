<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\saveme\models\Saveme */

$this->title = 'Update Saveme: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Savemes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="saveme-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
