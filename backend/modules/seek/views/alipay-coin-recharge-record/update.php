<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\member\models\AlipayCoinRechargeRecord */

$this->title = 'Update Alipay Coin Recharge Record: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Alipay Coin Recharge Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="alipay-coin-recharge-record-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
