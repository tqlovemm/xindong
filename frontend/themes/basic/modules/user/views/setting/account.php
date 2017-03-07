<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'nickname')->textInput() ?>

    <?= $form->field($model, 'cellphone')->textInput() ?>

    <?= $form->field($model, 'username')->textInput(['disabled'=>'false']) ?>
    <?= $form->field($model, 'email')->textInput(['disabled'=>'false']) ?>
    <?php
     $model->sex = ($model->sex) ? Yii::t('app', 'Female') : Yii::t('app', 'Male') ;
     echo $form->field($model, 'sex')->textInput(['disabled'=>'false'])
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' =>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
