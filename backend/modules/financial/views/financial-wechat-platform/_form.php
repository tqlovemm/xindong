<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\financial\models\FinancialWechatPlatform */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="financial-wechat-platform-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'platform_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
