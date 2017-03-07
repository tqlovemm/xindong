<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\WeichatVote */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weichat-vote-form">

    <?php $form = ActiveForm::begin(); $model->num = 0;?>

    <?= $form->field($model, 'sex')->dropDownList([0=>'男',1=>'女'])->label('性别') ?>

    <?= $form->field($model, 'enounce')->textInput(['maxlength' => true])->label('宣言') ?>

    <?= $form->field($model, 'num')->textInput()->label('点赞数') ?>

    <?= $form->field($model, 'enounce')->textInput()->label('平台编号或者微博号') ?>

    <?= $form->field($model, 'status')->dropDownList([0=>'不发布',1=>'发布'])->label('是否发布') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
