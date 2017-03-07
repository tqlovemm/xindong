<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\show\models\SeekSearch */
/* @var $form yii\widgets\ActiveForm */
$this->registerCss('

    #w0 input,#w0 label,#w0 button{float:left;margin:5px;}
    #w0 label{line-height:30px;}
    #w0 input{width:200px;}


');
?>

<div class="seeks-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>



    <?= $form->field($model, 'name') ?>

    <div class="form-group">
        <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
