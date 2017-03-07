<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\AppPush */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-push-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->dropDownList([0=>'不推送',2=>'推送到某些人',1=>'推送所有人']) ?>

    <?= $form->field($model, 'cid')->textInput(['maxlength' => true])->label('用户cid，若推送给所有人则不需要填写') ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('推送标题（如果是网站就填写网站名称：如十三平台）') ?>

    <?= $form->field($model, 'msg')->textInput(['maxlength' => true])->label('推送内容（如果是网站就填写网站链接：http://13loveme.com）')  ?>

    <?=$form->field($model,'type')->radioList(['SSCOMM_NOTICE'=>'通知','SSCOMM_AD_WEB'=>'网站','SSCOMM_LOGINOUT'=>'强制退出'])?>

    <?= $form->field($model, 'extras')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'platform')->dropDownList(['all'=>'ALL','ios'=>'IOS','android'=>'Android'])?>

    <?= $form->field($model, 'response')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
