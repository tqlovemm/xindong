<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\MemberSorts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-sorts-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'type')->dropDownList([0=>"简介图片",1=>'封面图片',2=>'顶部图片'])?>
    <?= $form->field($model, 'sort')->textInput()->label('排序') ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
