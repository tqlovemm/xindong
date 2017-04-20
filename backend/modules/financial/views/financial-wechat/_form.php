<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="financial-wechat-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'wechat')->textInput(['maxlength' => true,'required'=>true]) ?>
    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'member_count')->textInput(['type'=>'number','required'=>true]) ?>
    <?= $form->field($model, 'loose_change')->textInput(['type'=>'number'])?>
    <?= $form->field($model, 'status')->dropDownList([10=>"可见",0=>"不可见"]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['id'=>'submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<!--<script>
    $('#submit').click = function () {
        submitData();
    };
 function submitData() {
     $.get('wechat-exist?wechat='+$('#financialwechat-wechat').val(),function (data) {
         if(data==400){
             alert("微信号已经存在");
             $('#financialwechat-wechat').focus();
             return false;
         }
     });
 }
</script>-->