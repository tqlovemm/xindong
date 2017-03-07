<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\BgadminMemberFlop */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bgadmin-member-flop-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'floping_number')->textInput(['maxlength' => true])->label('翻牌者编号') ?>

    <?= $form->field($model, 'floped_number')->textInput()->label('被翻牌者编号') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
