<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = '其他收款记录';
?>
<div class="box box-info">
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="box-header with-border">
  <h3 class="box-title"><?=$this->title?></h3>
</div>
<div class="box-body">
  <div class="financial-wechat-join-record-form" style="padding: 10px;">
    <?= $form->field($model, 'yesterday')->dropDownList([strtotime('today')=>'今天',strtotime('yesterday')=>'昨天'])->label('是否计算入昨天')  ?>
    <?= $form->field($model, 'platform')->dropDownList($platform)->label('平台')  ?>
    <?= $form->field($model, 'vip')->textInput(['maxlength' => true])->label('付款事由简述')  ?>
    <?= $form->field($model, 'number')->textInput(['maxlength' => true])->label('会员编号')  ?>
    <?= $form->field($model, 'channel')->dropDownList(['微信'=>'微信','支付宝'=>'支付宝','淘宝'=>'淘宝','公司银行卡转账'=>'公司银行卡转账','海外代充'=>'海外代充'])->label('付款渠道')  ?>
    <?= $form->field($model, 'payment_to')->dropDownList([2=>'微信客服号',1=>'收款专用号'])->label('付款到')  ?>
    <?= $form->field($model, 'payment_amount')->textInput()->label('付款金额')  ?>
    <?= $form->field($model, 'payment_screenshot')->fileInput() ?>
    <?= $form->field($model, 'remarks')->textarea(['maxlength' => true,'placeholder'=>'可填写付款事由详情等'])->label('备注')  ?>
  </div>
</div>
<div class="box-footer">
  <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  </div>
</div>
<?php ActiveForm::end(); ?>
</div>