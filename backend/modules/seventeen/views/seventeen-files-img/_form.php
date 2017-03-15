<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\seventeen\models\SeventeenFilesImg */
/* @var $form yii\widgets\ActiveForm */
$pre_url = Yii::$app->params['qiniushiqi'];
?>

<div class="seventeen-files-img-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //echo $form->field($model, 'text_id')->textInput() ?>

    <?php //echo $form->field($model, 'img')->textInput(['maxlength' => true]) ?>

    <div class=""><img style="width: 200px;" src="<?=$pre_url.$model->img?>"></div>

    <?= $form->field($model, 'type')->dropDownList([0=>'设为正常身材照',2=>'设为头像封面照',1=>'设为微信二维码']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
