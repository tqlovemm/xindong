<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\forum\models\AnecdoteThreadReport */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="anecdote-thread-report-form">

    <?php $form = ActiveForm::begin(); ?>
<!--
    <?/*= $form->field($model, 'id')->textInput() */?>-->

    <?= $form->field($model, 'tid')->textInput() ?>

    <?= $form->field($model, 'by_who')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'result')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([1=>'举报成功',2=>'举报失败']) ?><!--

    <?/*= $form->field($model, 'created_at')->textInput() */?>

    <?/*= $form->field($model, 'updated_at')->textInput() */?>-->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
