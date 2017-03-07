<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\user\models\Mark;
use yii\helpers\ArrayHelper;
use yii\web\View;
$mark=Mark::find()->all();

$listData1=ArrayHelper::map($mark,'mark_name','mark_name');
$listData2=ArrayHelper::map($mark,'make_friend_name','make_friend_name');
$listData3=ArrayHelper::map($mark,'hobby_name','hobby_name');

/* @var $this yii\web\View */
/* @var $profile app\modules\user\models\Profile */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(Yii::getAlias('@web')."/js/jquery-1.11.3.js",['position' => View::POS_HEAD]);
?>

        <?php $form = ActiveForm::begin(); ?>

        <?=$form->field($profile, 'mark')->textInput(['disabled'=>'false'])?>

        <?= $form->field($profile, 'mark')->dropDownList($listData1,[
            'class'=>'selectpicker form-control','multiple'=>true,'data-live-search'=>true
        ])->label(false) ?>
        <hr>
        <?=$form->field($profile, 'make_friend')->textInput(['disabled'=>'false'])?>
        <?= $form->field($profile, 'make_friend')->dropDownList($listData2,[
            'class'=>'selectpicker form-control','multiple'=>true,'data-live-search'=>true
        ])->label(false) ?>

        <hr>
        <?=$form->field($profile, 'hobby')->textInput(['disabled'=>'false'])?>
        <?= $form->field($profile, 'hobby')->dropDownList($listData3,[
            'class'=>'selectpicker form-control','multiple'=>true,'data-live-search'=>true
        ])->label(false) ?>



        <div class="form-group">
            <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

<script type="text/javascript">
    $(window).on('load', function () {

        $('.selectpicker').selectpicker({


        });

        // $('.selectpicker').selectpicker('hide');
    });
</script>



