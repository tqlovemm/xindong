<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\recharge\models\AutoJoinPrice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auto-join-price-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'member_sort')->dropDownList([2=>'普通会员',3=>'高端会员',4=>'至尊会员']) ?>

    <?= $form->field($model, 'member_area')->dropDownList([1=>'新蒙青甘藏宁琼',2=>'包括海外在内的其他地区',3=>'北上广苏浙']) ?>

    <?= $form->field($model, 'recharge_type')->dropDownList([1=>'会员价格',2=>'套餐A',3=>'套餐B',4=>'套餐C']) ?>

    <?= $form->field($model, 'type_content')->textInput() ?>
    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
