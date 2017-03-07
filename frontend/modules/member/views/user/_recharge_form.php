<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RechargeRecord */
/* @var $form ActiveForm */
?>
<div class="row recharge_form" style="background-color: white;padding:10px;">

    <h1 class="text-center">节操币充值</h1>
    <div class="form-group" style="padding:10px;text-align: center;">
        <img class="img-responsive center-block" style="width: 80px;border-radius: 50%;" src="<?=$userInfo['avatar']?>">
        <h5><?=$userInfo['username']?>(<?=$userInfo['nickname']?>)</h5>
        <h5>微信号：<?=$userInfo['weichat']?></h5>
    </div>
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'number')->textInput(['placeholder'=>'请在此填写充值金额1-10000元','style'=>'border:none;'])->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('下一步', ['class' => 'btn btn-primary','style'=>'border-color:#E83F78;background-color:#E83F78;width:100%;padding: 2px 0;font-size:20px;',]) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- _recharge_form -->
