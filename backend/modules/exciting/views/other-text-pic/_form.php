<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\exciting\models\WebsiteContent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weekly-content-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true])->label('会员编号') ?>
    <?= $form->field($model, 'name')->dropDownList($area) ?>
    <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->dropDownList([1 => '不发布',2=>'发布'])->label('是否发布') ?>
    <?= $form->field($model, 'coin')->label('需要节操币') ?>
    <?php if($model->type==4):?>
        <?= $form->field($model, 'expire')->dropDownList([34000=>'Forever',12=>'12 hours',24=>'24 hours',36=>'36 hours',48=>'2 days',72=>'3 days',120=>'5 days',168=>'A week',336=>'2 weeks',720=>'One month',1464=>'2 months',2208=>'3 months',4320=>'Half a year',8760=>'A year'])->label('过期时间') ?>
    <?php elseif($model->type==3):?>
        <?= $form->field($model, 'expire')->label('过期时间') ?>
    <?php endif;?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
