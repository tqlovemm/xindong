<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerCss("

    .distpicker .form-control{width: 200px;float: left;margin-right:15px;}

");
     
/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\SendUrlToUser */
/* @var $form ActiveForm */
?>
<div class="send_url">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'weichat')->label('微信号') ?>
        <label>地区一</label>
        <div class="distpicker" data-toggle="distpicker">
            <div class="form-group clearfix">
                <select class="form-control" name="province1"></select>
                <select class="form-control" name="city1"></select>
            </div>
        </div>
        <label>地区二</label>
        <div class="distpicker" id="distpicker4" data-toggle="distpicker5">
            <div class="form-group clearfix">
                <select class="form-control" name="province2"></select>
                <select class="form-control" name="city2"></select>
            </div>
        </div>
        <label>地区三</label>
        <div class="distpicker" id="distpicker5" data-toggle="distpicker5">
            <div class="form-group clearfix">
                <select class="form-control" name="province3"></select>
                <select class="form-control" name="city3"></select>
            </div>
        </div>
        <?= $form->field($model, 'level')->dropDownList(['1'=>'网站会员','2'=>"普通会员",'3'=>'高端会员','4'=>'至尊会员','5'=>'私人定制'])->label('会员等级') ?>
        <?= $form->field($model, 'number')->textInput()->label('十三编号') ?>
        <?= $form->field($model, 'jiecao_coin')->textInput()->label('节操币数量') ?>
        <?= $form->field($model, 'description')->label('发送链接理由') ?>
    
        <div class="form-group">
            <h4 class="text-red text-bold">链接一旦生成二十四小时后即会失效，请友情提醒会员!!</h4>
            <?= Html::submitButton('生成链接', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- send_url -->
<?php

$this->registerJs("

    $('#distpicker5,#distpicker4').distpicker({
  autoSelect: false
});

");
?>