<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\financial\models\FinancialWechatMemberIncrease */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="financial-wechat-member-increase-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'increase_boy_count')->textInput(['required'=>true]) ?>
    <?= $form->field($model, 'increase_girl_count')->textInput(['required'=>true]) ?>
    <?= $form->field($model, 'total_count')->textInput(['required'=>true]) ?>
    <?= $form->field($model, 'reduce_count')->textInput() ?>
    <?= $form->field($model, 'loose_change')->textInput() ?>
    <?= $form->field($model, 'remarks')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
