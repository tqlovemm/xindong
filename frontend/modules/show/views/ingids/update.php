<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\show\models\Seeks */

$this->title = 'Update Seeks: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Seeks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="seeks-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
