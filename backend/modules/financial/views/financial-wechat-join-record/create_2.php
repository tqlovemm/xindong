<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = '会员升级收款记录';
?>
<div class="box box-info">
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="box-header with-border">
  <h3 class="box-title"><?=$this->title?></h3>
</div>
<div class="box-body">
  <div class="financial-wechat-join-record-form" style="padding: 10px;">
    <?= $form->field($model, 'vip')->textInput(['maxlength' => true])->label('会员升级等级')  ?>
    <?= $form->field($model, 'channel')->textInput(['maxlength' => true])->label('付款渠道')  ?>
    <?= $form->field($model, 'payment_to')->dropDownList([1=>'收款专用号',2=>'微信客服号'])->label('付款到')  ?>
    <?= $form->field($model, 'payment_amount')->textInput()->label('付款金额')  ?>
    <?= $form->field($model, 'payment_screenshot')->fileInput() ?>
    <?= $form->field($model, 'remarks')->textarea(['maxlength' => true,'placeholder'=>'可填写会员由什么等级升级到什么等级，会员编号地区等情况'])->label('备注')  ?>
  </div>
</div>
<div class="box-footer">
  <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  </div>
</div>
<?php ActiveForm::end(); ?>
</div>
