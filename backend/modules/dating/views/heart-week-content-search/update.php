<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\recharge\models\RechargeContent */

$this->title = Html::encode(strip_tags($model->name)) ;
$this->params['breadcrumbs'][] = ['label' => 'Recharge Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="Recharge-content-update">

    <h1><?= $this->title ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
