<?php
use yii\widgets\ActiveForm;
?>
<?php if(Yii::$app->session->hasFlash('success')):?>
    <?=Yii::$app->session->getFlash('success')?>
<?php endif;?>
<h2>为会员编号：<?=Yii::$app->request->get('id')?>   添加相关截图</h2>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'file')->fileInput() ?>
<?= $form->field($model, 'extra')->textInput()->label('备注') ?>

    <button>提交</button>

<?php ActiveForm::end() ?>