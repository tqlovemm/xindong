<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="financial-wechat-member-increase-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'increase_boy_count')->textInput(['value'=>0]) ?>
    <?= $form->field($model, 'increase_girl_count')->textInput(['value'=>0]) ?>
    <?= $form->field($model, 'total_count')->textInput() ?>
    <?= $form->field($model, 'reduce_count')->textInput(['value'=>0]) ?>
    <?= $form->field($model, 'loose_change')->textInput() ?>
    <?= $form->field($model, 'remarks')->textInput() ?>
    <?= $form->field($model, 'wechat_loose_change_screenshot')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$this->registerJs("
  $('#financialwechatmemberincrease-increase_boy_count,#financialwechatmemberincrease-increase_girl_count').blur(function () {
        $('#financialwechatmemberincrease-total_count').val($total_count+parseInt($('#financialwechatmemberincrease-increase_boy_count').val())+parseInt($('#financialwechatmemberincrease-increase_girl_count').val()));
    });
");
?>