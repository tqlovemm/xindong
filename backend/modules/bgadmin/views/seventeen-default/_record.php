<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\SeventeenadminMember */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bgadmin-member-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->dropDownList([0=>'二维码',1=>'生活档案中',2=>'付款截图',3=>'聊天截图',5=>'翻牌记录',6=>'密约记录',7=>'7反馈',8=>'其他'],['prompt'=>'----请选择类型----']) ?>
    <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'member_id')->hiddenInput(['maxlength' => true,'value'=>$_GET['id']])->label(false) ?>
    <?= $form->field($model, 'time')->widget('common\widgets\laydate\LayDate', [
        'clientOptions' => [
            'istoday' => false,
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
