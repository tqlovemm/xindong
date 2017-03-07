<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\seek\models\AlipayCoinRechargeRecordSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alipay-coin-recharge-record-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'user_number') ?>

    <?= $form->field($model, 'total_fee') ?>

    <?= $form->field($model, 'giveaway') ?>

    <?php // echo $form->field($model, 'out_trade_no') ?>

    <?php // echo $form->field($model, 'subject') ?>

    <?php // echo $form->field($model, 'notify_time') ?>

    <?php // echo $form->field($model, 'extra') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'day_time') ?>

    <?php // echo $form->field($model, 'week_time') ?>

    <?php // echo $form->field($model, 'mouth_time') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'platform') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
