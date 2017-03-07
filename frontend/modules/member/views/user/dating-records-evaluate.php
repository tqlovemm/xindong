<?php
$this->title = "评价";
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCss("
    .weui_cell_primary p{margin-bottom:0;}
    .weui_check_label{margin-bottom:0;}
");
?>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<div class="dating-records-evaluate">
    <div class="row member-center">
        <header>
            <div class="header">
                <a href="javascript:history.back();"><span><img
                            src="<?= Yii::getAlias('@web') ?>/images/iconfont-fanhui.png"></span></a>
                <h2 style="margin:0;"><?= $this->title ?></h2>
            </div>
        </header>
    </div>

    <?php $form = ActiveForm::begin(); ?>
        <div class="weui_cells weui_cells_radio">
            <label class="weui_cell weui_check_label" for="x11">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>好评</p>
                </div>
                <div class="weui_cell_ft">
                    <input type="radio" class="weui_check" name="evaluate" id="x11" value="1" checked="checked">
                    <span class="weui_icon_checked"></span>
                </div>
            </label>
            <label class="weui_cell weui_check_label" for="x12">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>差评</p>
                </div>
                <div class="weui_cell_ft">
                    <input type="radio" name="evaluate" class="weui_check" id="x12" value="2">
                    <span class="weui_icon_checked"></span>
                </div>
            </label>
        </div>
        <?= $form->field($model, 'text')->textarea(['style'=>"height:100px;border:none;margin-top:10px;",'placeholder'=>"输入您对女生的印象"])->label(false) ?>
        <div class="form-group">
            <?= Html::submitButton('提交评价', ['class' => 'btn btn-success center-block','style'=>"width:100%;"]) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- dating-records-evaluate -->
