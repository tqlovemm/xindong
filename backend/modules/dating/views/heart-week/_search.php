<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


$this->registerCss("
        .recharge-search:after{content:'.';height: 0;visibility: hidden;clear:both;display: block;}
        .recharge-search .form-group{width:15%;float:left;}

");
?>

<div class="recharge-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'title')->dropDownList(ArrayHelper::map(\backend\modules\dating\models\HeartWeek::findAll(["status"=>2]), 'title', 'title'), ['prompt'=>'Select...'])->label('省份')?>
    <?= $form->field($model, 'number')->label('妹子编号')?>
    <?= $form->field($model, 'id') ?>
    <?= $form->field($model, 'cover_id')->dropDownList([0=>'显示',-1=>'隐藏'])->label("显示还是隐藏")?>


    <div class="form-group" style="line-height: 80px;">
        <?= Html::submitButton('管理员查找', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


