<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CollectingFilesText */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="collecting17-files-text-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->textInput()->label('填写进度：0为未填写，1为已填写表单一，2为已填写表单二。修改为0可以让会员重新填写表单一，改为1可以让会员重新填写表单二') ?>

    <?= $form->field($model, 'weichat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cellphone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_province')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_detail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'education')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->textInput()->label('性别：0男，1女') ?>

    <?= $form->field($model, 'height')->textInput() ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'cup')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job_detail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weibo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay')->textInput() ?>

    <?= $form->field($model, 'qq')->textInput() ?>

    <?= $form->field($model, 'extra')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
