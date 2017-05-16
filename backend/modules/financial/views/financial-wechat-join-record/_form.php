<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="financial-wechat-member-increase-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'platform')->dropDownList($platform)->label('平台')  ?>
    <?= $form->field($model, 'vip')->textInput(['maxlength' => true])->label('会员等级')  ?>
    <?= $form->field($model, 'number')->textInput(['maxlength' => true])->label('会员编号')  ?>
    <?= $form->field($model, 'join_source')->dropDownList([
        '微博'=>'微博','微信公众号'=>'微信公众号','知乎'=>'知乎','Twitter'=>'Twitter',
        'Facebook'=>'Facebook','Instagram'=>'Instagram','朋友推荐'=>'朋友推荐',
        '微信朋友圈'=>'微信朋友圈','官网'=>'官网','APP'=>'APP','其他'=>'其他'])->label('入会来源')  ?>
    <?= $form->field($model, 'channel')->dropDownList(['微信'=>'微信','支付宝'=>'支付宝','淘宝'=>'淘宝','公司银行卡转账'=>'公司银行卡转账','海外代充'=>'海外代充'])->label('付款渠道')  ?>
    <?= $form->field($model, 'payment_to')->dropDownList([1=>'收款专用号',2=>'微信客服号'])->label('付款到')  ?>
    <?= $form->field($model, 'payment_amount')->textInput()->label('付款金额')  ?>
    <?= $form->field($model, 'remarks')->textarea(['maxlength' => true,'placeholder'=>'可填写打折情况，入会编号以及其他详情情况'])->label('备注')  ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
/*
$this->registerJs("
  $('#financialwechatmemberincrease-increase_boy_count,#financialwechatmemberincrease-increase_girl_count').blur(function () {
        $('#financialwechatmemberincrease-total_count').val($total_count+parseInt($('#financialwechatmemberincrease-increase_boy_count').val())+parseInt($('#financialwechatmemberincrease-increase_girl_count').val()));
    });
");
*/?>