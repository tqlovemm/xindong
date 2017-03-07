<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title = "账户设置";
?>
<div class="row member-center">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?=$this->title?></h2>
        </div>
    </header>
</div>
<div class="user-form" style="padding:10px 0;">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'nickname')->textInput() ?>

    <?= $form->field($model, 'cellphone')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'username')->textInput(['disabled'=>'false']) ?>

    <?php
     $model->sex = ($model->sex) ? Yii::t('app', 'Female') : Yii::t('app', 'Male') ;
     echo $form->field($model, 'sex')->textInput(['disabled'=>'false'])
    ?>

    <div class="form-group">
        <?= Html::submitButton("保存", ['class' =>'btn btn-warning','style'=>'width:100%;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
