<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => 32,'disabled'=>true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 32,'disabled'=>true]) ?>

    <?= $form->field($model, 'groupid')->dropDownList([2 =>'普通会员',3=>'高端会员',4=>'至尊会员',5=>'私人定制']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'identify')->textInput(['maxlength' => 64])->label('微信号') ?>

    <?= $form->field($model, 'status')->textInput()->label('状态码：10为正常访问网址，0则封号无法登陆网址') ?>

    <?php echo $form->field($model, 'salary')->textInput() ?>

    <?php  echo $form->field($model, 'job')->textInput()->label('职业') ?>
    <?php  echo $form->field($model, 'car')->textInput()->label('车型') ?>
    <?php  echo $form->field($model, 'weibo_num')->textInput() ?>
    <?php  echo $form->field($model, 'cup')->textInput() ?>

    <label>用户头像</label>
    <img src="<?=$model->avatar?>">

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
