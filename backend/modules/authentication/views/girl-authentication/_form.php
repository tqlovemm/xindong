<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\authentication\models\GirlAuthentication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="girl-authentication-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'video_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'status')->textInput()->dropDownList([1=>'认证成功',2=>'认证失败',3=>'未认证']) ?>
    <?php if($update == 1){ ?>
        <div class="form-group">
            <label class="control-label">备注 (认证失败填写理由，认证成功不用填写。PS：认证失败也可以不写，将发送默认提醒)</label>
            <input type="text" class="form-control" name="beizhu">

            <div class="help-block"></div>
        </div>
    <?php } ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
