<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCss('

     .edui-body-container img{width:100px;height:100px;float:left;}
    .edui-body-container p:nth-last-child(1){clear:both;}
');
?>

<div class="message-form">

    <?php $form = ActiveForm::begin();

        if(!empty($from)){

             $froms = $from;

        }else{

            $froms = '';
        }
    ?>


    <?php if(Yii::$app->user->id!=10000){?>

    <?= $form->field($model, 'sendto', [
        'template' => "<div class=\"input-group\"><span class=\"input-group-addon\">" . Yii::t('app', 'Sendto') . "</span>{input}</div>{error}",
    ])->textInput(['maxlength' => 32, 'autocomplete'=>'off','value'=>'admin','readonly'=>'true']) ?>

    <?php }else{?>

    <?= $form->field($model, 'sendto', [
        'template' => "<div class=\"input-group\"><span class=\"input-group-addon\">" . Yii::t('app', 'Sendto') . "</span>{input}</div>{error}",
    ])->textInput(['maxlength' => 32, 'autocomplete'=>'off','value'=>$froms]) ?>

    <?php }?>

    <?= $form->field($model, 'subject', [
        'template' => "<div class=\"input-group\"><span class=\"input-group-addon\">" . Yii::t('app', 'Subject') . "</span>{input}</div>{error}",
    ])->textInput(['maxlength' => 32, 'autocomplete'=>'off']) ?>

    <?= $form->field($model, 'content')->widget('shiyang\umeditor\UMeditor', [
        'clientOptions' => [
            'initialFrameHeight' => 230,
            'toolbar' => [

                '| emotion image |',

            ],
        ]
    ])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
