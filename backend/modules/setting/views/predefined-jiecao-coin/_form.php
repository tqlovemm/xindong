<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\PredefinedJiecaoCoin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="predefined-jiecao-coin-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'money')->textInput()->label("充值金额") ?>

    <?= $form->field($model, 'giveaway')->textInput()->label("赠送节操币（没有请写0）") ?>

    <?= $form->field($model, 'is_activity')->dropDownList([0=>'正常充值',1=>'活动充值'])->label("是否是活动充值，活动只能充值一次，仅对APP有效") ?>
    <?= $form->field($model, 'type')->dropDownList([0=>'网站',1=>'APPStore',2=>'APP微信支付宝'])->label("平台") ?>
    <?= $form->field($model, 'member_type')->dropDownList([0=>'所有',2=>'普通会员',3=>'高端会员',4=>'至尊会员',5=>'私人订制'])->label("会员等级，平台为网站和APPStore则选择所有") ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
