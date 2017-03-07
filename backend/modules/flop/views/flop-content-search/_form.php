<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\flop\models\FlopContent;
/* @var $this yii\web\View */
/* @var $model backend\modules\weekly\models\WeeklyContent */
/* @var $form yii\widgets\ActiveForm */
$query = new FlopContent();
$flop_id = ArrayHelper::map($query->findAll(['is_cover'=>1]),'flop_id','area');

?>

<div class="weekly-content-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'flop_id')->dropDownList($flop_id)->label('地区编号') ?>
    <?= $form->field($model, 'number')->textInput(['maxlength' => true])->label('编号') ?>
    <?= $form->field($model, 'sex')->dropDownList(['0'=>'男','1'=>'女'])->label('性别') ?>
    <?= $form->field($model, 'height')->textInput(['maxlength' => true])->label('身高（cm）') ?>
    <?= $form->field($model, 'weight')->textInput(['maxlength' => true])->label('体重（kg）') ?>
    <?= $form->field($model, 'content')->textInput(['maxlength' => true])->label('个性简介') ?>
    <?= $form->field($model, 'is_cover')->dropDownList(['0'=>'否','1'=>'是'])->label('是否发布') ?>
    <?= $form->field($model, 'other')->dropDownList([1=>'是',0=>'否'])->label('是否好评')?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
