<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $profile app\modules\user\models\Profile */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title = "个人设置";

?>

<div class="row member-center">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?=$this->title?></h2>
        </div>
    </header>
</div>
<div class="row" style="margin-top: 10px;">
    <div class="col-md-7">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($profile, 'birthdate')->widget('common\widgets\laydate\LayDate', [
            'clientOptions' => [
                'istoday' => false,
            ]
        ]) ?>

        <?= $form->field($profile, 'signature')->textarea() ?>
        <?= $form->field($profile, 'height')->textInput() ?>
        <?= $form->field($profile, 'weight')->textInput() ?>
        <?php if(!empty($profile->address_1)):?>
            <?= $form->field($profile, 'address_1')->textInput(['disabled'=>true]) ?>
        <?php endif;?>
        <?php if(!empty($profile->address_2)):?>
            <?= $form->field($profile, 'address_2')->textInput(['disabled'=>true]) ?>
        <?php endif;?>
        <?php if(!empty($profile->address_3)):?>
            <?= $form->field($profile, 'address_3')->textInput(['disabled'=>true]) ?>
        <?php endif;?>

        <div class="form-group">
            <?= Html::submitButton('保存', ['class' => 'btn btn-warning','style'=>'width:100%;']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <div class="col-md-5">
        <div class="form-group">
            <div class="col-md-6">
              <div class="fileupload fileupload-new">
                <div class="fileupload-new img-preview center-block " style="width: 150px; height: 150px;">
                  <img class="img-responsive" src="<?= $model->avatar ?>"  style="width: 150px; height: 150px;">
                </div>
              </div>
            </div>
            <div class="col-md-6 hidden">
                <div class="fileupload fileupload-new">
                    <div class="img-preview"></div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="form-group">
            <div class="col-md-12 text-center">
                <?= \shiyang\webuploader\Cropper::widget() ?>
            </div>
            <div class="col-md-12">
                <div id="avatar-container"></div><!-- 系统头像容器 -->
            </div>
        </div>
    </div>
</div>