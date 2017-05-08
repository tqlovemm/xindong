<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\saveme\models\SavemeInfo */

$this->title = 'Update Saveme Info: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Saveme Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="saveme-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
