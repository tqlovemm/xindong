<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\MemberSorts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-sorts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'member_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'groupid')->dropDownList([2=>'普通会员',3=>'高端会员',4=>'至尊会员',5=>'私人订制'])->label("会员等级") ?>

    <?= $form->field($model, 'member_introduce')->textarea(['maxlength' => true])->label("注册流程（不同之间请用@符号隔开，如：1@2@3）") ?>
    <?= $form->field($model, 'permissions')->textarea(['maxlength' => true])->label("十三平台声明（不同之间请用@符号隔开，如：1@2@3）") ?>
    <?= $form->field($model, 'giveaway')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'giveaway_qun')->textInput() ?>
    <?= $form->field($model, 'price_1')->textInput() ?>
    <?= $form->field($model, 'price_2')->textInput() ?>
    <?= $form->field($model, 'price_3')->textInput() ?>

    <?= $form->field($model, 'discount')->textInput()->label('打折的折扣，不打折为1，九五折为0.95') ?>
    <?= $form->field($model, 'is_recommend')->dropDownList([1=>'是',0 =>'否'])->label("是否推荐") ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
