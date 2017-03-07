<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\UserHowPlay */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-how-play-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'instruction')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rule')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'inline_time')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'weibo')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'explain')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'flag')->checkbox([1=>'高级会员',2=>'普通会员']) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
