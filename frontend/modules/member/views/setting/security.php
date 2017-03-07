<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '密码修改';
$this->registerCss("
    .user-form{padding:10px;}
");
?>

<div class="row member-center">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?=$this->title?></h2>
        </div>
    </header>
</div>
<div class="row user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'oldPassword')->textInput() ?>

    <?= $form->field($model, 'newPassword')->textInput() ?>

    <?= $form->field($model, 'verifyPassword')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-warning', 'style'=>'width:100%;font-size:14px;',]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
