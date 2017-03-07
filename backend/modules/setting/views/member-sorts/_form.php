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
    <?= $form->field($model, 'groupid')->dropDownList([1=>1,2=>2,3=>3,4=>4,5=>5])->label('会员组：1网站普通会员，2平台普通会员，2平台高端会员，3平台至尊会员，4平台私人订制') ?>

    <?= $form->field($model, 'member_introduce')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'permissions')->textarea(['maxlength' => true])->label("会员权限（不同的权限之间请用@符号隔开，如：权限1@权限2@权限3）") ?>

    <?= $form->field($model, 'price_1')->textInput() ?>
    <?= $form->field($model, 'price_2')->textInput() ?>
    <?= $form->field($model, 'price_3')->textInput() ?>

    <?= $form->field($model, 'discount')->textInput()->label('打折的折扣，不打折为1，九五折为0.95') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
