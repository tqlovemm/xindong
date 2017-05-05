<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\male\models\MaleInfoText */

$this->title = 'Create Male Info Text';
$this->params['breadcrumbs'][] = ['label' => 'Male Info Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="male-info-text-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
