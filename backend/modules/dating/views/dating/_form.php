<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\home\models\Album */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="album-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => 128]) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => 128]) ?>
    <?= $form->field($model, 'title2')->textInput(['maxlength' => 128]) ?>
    <?= $form->field($model, 'title3')->textInput(['maxlength' => 128]) ?>
    <?= $form->field($model, 'content')->textInput(['maxlength' => 128]) ?>
    <?= $form->field($model, 'introduction')->textInput(['maxlength' => 512]) ?>
    <?php $model->expire=48?>
    <?= $form->field($model, 'expire')->textInput(['maxlength' => 512]) ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => 128]) ?>
    <?= $form->field($model, 'worth')->textInput()->label('妹子的价值，会员索取她需要扣除相应的节操币（50-80）') ?>
    <?= $form->field($model,'sort')->dropDownList([1=>'最前','0'=>'最后'])->label('排序')?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
