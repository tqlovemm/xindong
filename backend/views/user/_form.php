<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => 32,'disabled'=>true]) ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => 32,'disabled'=>true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => 64]) ?>
    <?= $form->field($model, 'cellphone')->textInput() ?>
    <?= $form->field($model, 'sex')->dropDownList([0=>'男生',1=>'女生'])->label('性别') ?>
    <?= $form->field($model, 'status')->dropDownList([0=>'封号',10=>'开通'])->label('是否封号，如果封号网站和APP将同时无法登陆') ?>

    <label>用户头像</label>
    <img src="<?=$model->avatar?>">

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
