<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\active\models\NewYearGood */

$this->title = 'Update New Year Good: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'New Year Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="new-year-good-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
