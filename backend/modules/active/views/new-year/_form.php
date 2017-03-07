<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\active\models\NewYear */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="new-year-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sex')->dropDownList([0=>'男',1=>'女'])->label('选择性别') ?>

    <?= $form->field($model, 'enounce')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'openId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'plateId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([1=>'审核中',2=>'审核通过',3=>'审核不通过']) ?>

   <!-- <?/*= $form->field($model, 'created_at')->textInput() */?>

   <?/*= $form->field($model, 'updated_at')->textInput() */?> -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
