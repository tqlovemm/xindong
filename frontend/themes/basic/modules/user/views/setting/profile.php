<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $profile app\modules\user\models\Profile */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */


?>
<div class="row">
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

        <?= $form->field($profile, 'address')->textarea() ?>

        <?= $form->field($profile, 'description')->textarea() ?>

        <div class="form-group">
            <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label class="control-label col-md-12">在账户信息中添加昵称和手机号才可以自定义头像哦</label>
            <div class="col-md-6">
              <div class="fileupload fileupload-new">
                <div class="fileupload-new img-preview" style="width: 150px; height: 150px;">
                  <img src="<?= $model->avatar ?>"  style="width: 150px; height: 150px;">
                </div>
              </div>
            </div>
            <div class="col-md-6">
                <div class="fileupload fileupload-new">
                    <div class="img-preview"></div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="form-group">
            <div class="col-md-12">
                <?= \shiyang\webuploader\Cropper::widget() ?>
            </div>
            <div class="col-md-12">
                <a id="set-avatar" class="btn btn-success btn-lg" href="<?= Url::toRoute(['/user/setting/avatar']) ?>" onclick="return false;">
                    系统头像
                </a>
                <div id="avatar-container"></div><!-- 系统头像容器 -->
            </div>
        </div>
    </div>
</div>
