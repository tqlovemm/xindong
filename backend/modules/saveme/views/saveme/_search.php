<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerCss("
    .saveme-search:after{content:'.';height: 0;visibility: hidden;clear:both;display: block;}
    .saveme-search .form-group{width:15%;float:left;margin-left: 3px;}
");
/* @var $this yii\web\View */
/* @var $model backend\modules\saveme\models\SavemeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="saveme-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'created_id') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'content') ?>

    <div class="form-group" style="line-height: 80px;">
        <?= Html::submitButton('查找', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
