<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = '会员入会收款记录';
?>
<div class="box box-info">
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="box-header with-border">
  <h3 class="box-title"><?=$this->title?></h3>
</div>
<div class="box-body">
  <div class="financial-wechat-join-record-form" style="padding: 10px;">
    <?= $form->field($model, 'platform')->dropDownList($platform)->label('平台')  ?>
    <?= $form->field($model, 'vip')->textInput(['maxlength' => true])->label('会员等级')  ?>
    <?= $form->field($model, 'number')->textInput(['maxlength' => true])->label('会员编号')  ?>
    <?= $form->field($model, 'join_source')->textInput(['maxlength' => true])->label('入会来源')  ?>
    <?= $form->field($model, 'channel')->textInput(['maxlength' => true])->label('付款渠道')  ?>
    <?= $form->field($model, 'payment_to')->dropDownList([1=>'收款专用号',2=>'微信客服号'])->label('付款到')  ?>
    <?= $form->field($model, 'payment_amount')->textInput()->label('付款金额')  ?>
    <?= $form->field($model, 'payment_screenshot')->fileInput() ?>
    <?= $form->field($model, 'join_address')->dropDownList($province)->label('入会地址')  ?>
    <?= $form->field($model, 'remarks')->textarea(['maxlength' => true,'placeholder'=>'可填写打折情况，入会编号以及其他详情情况'])->label('备注')  ?>
  </div>
</div>
<div class="box-footer">
  <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  </div>
</div>
<?php ActiveForm::end(); ?>
</div>