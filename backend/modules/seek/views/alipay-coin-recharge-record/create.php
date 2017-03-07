<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\member\models\AlipayCoinRechargeRecord */

$this->title = 'Create Alipay Coin Recharge Record';
$this->params['breadcrumbs'][] = ['label' => 'Alipay Coin Recharge Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alipay-coin-recharge-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
