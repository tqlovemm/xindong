<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\SeventeenadminMember */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bgadmin-member-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time')->widget('common\widgets\laydate\LayDate', [
        'clientOptions' => [
            'istoday' => false,
        ]
    ]) ?>

    <?= $form->field($model, 'sex')->dropDownList([0=>'男生',1=>'女生'],['prompt'=>'----请选择性别----']) ?>

    <?= $form->field($model, 'vip')->dropDownList([0=>'非会员',1=>'女生会员',2=>'普通会员',3=>'高端会员',4=>'至尊会员',5=>'私人定制'],['prompt'=>'----会员等级----']) ?>

    <?= $form->field($model, 'weicaht')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weibo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cellphone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_a')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_b')->textInput(['maxlength' => true]) ?>



    <?php //echo $form->field($model, 'status')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
