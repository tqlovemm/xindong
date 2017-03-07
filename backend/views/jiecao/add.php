<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Jiecao */
/* @var $form ActiveForm */
?>
<?php if(Yii::$app->session->hasFlash('result')):?>
    <div class="alert alert-warning"><?=Yii::$app->session->getFlash('result')?></div>
<?php endif;?>
<div class="add">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'number')->label("会员编号") ?>
        <?= $form->field($model, 'jiecao')->label("节操币数量") ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', [
                'class' => 'btn btn-primary',
                'data-confirm'=>"确认给编号{$model->number}的会员添加节操币吗"
            ]) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- add -->
