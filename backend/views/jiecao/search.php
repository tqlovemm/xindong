<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
?>
<?php if(Yii::$app->session->hasFlash('fail')):?>
    <div class="alert alert-danger"><?=Yii::$app->session->getFlash('fail')?></div>
<?php endif;?>
<?php if(isset($jiecao)):?>
    <h1 style="border: 1px solid red;padding:10px;text-align: center;">会员编号：<?=$profile->number?>，拥有节操币数量：<?=$jiecao?></h1>
<?php endif;?>
<?php $form=ActiveForm::begin();?>
    <?=$form->field($profile,'number')->textInput()->label('会员编号')?>
    <div class="form-group">
        <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end();?>


