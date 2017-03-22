<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\ScanWeimaDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scan-weima-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'customer_service') ?>
    <?= $form->field($model, 'account_manager') ?>
    <?= $form->field($model, 'description') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

