<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\financial\models\FinancialWechatJoinRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="financial-wechat-join-record-form" style="padding: 10px;">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'type')->dropDownList([0=>'会员入会',1=>'会员升级'])->label('类型') ?>
    <?= $form->field($model, 'vip')->textInput(['maxlength' => true])->label('会员等级')  ?>
    <?= $form->field($model, 'join_source')->textInput(['maxlength' => true])->label('入会来源')  ?>
    <?= $form->field($model, 'channel')->textInput(['maxlength' => true])->label('付款渠道')  ?>
    <?= $form->field($model, 'payment_to')->dropDownList([1=>'收款专用号',2=>'微信客服号'])->label('付款到')  ?>
    <?= $form->field($model, 'payment_amount')->textInput()->label('付款金额')  ?>
    <?= $form->field($model, 'payment_screenshot')->fileInput() ?>
    <?= $form->field($model, 'join_address')->dropDownList($province)->label('入会地址')  ?>
    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true])->label('备注')  ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
