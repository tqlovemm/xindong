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
        <?= $form->field($model, 'groupid')->dropDownList([1=>"没有等级",2=>"普通会员",3=>"高端会员",4=>"至尊会员",5=>"私人定制",])->label("会员等级") ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', [
                'class' => 'btn btn-primary',
                'data-confirm'=>"确认给编号{$model->number}的会员升级吗"
            ]) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- add -->
