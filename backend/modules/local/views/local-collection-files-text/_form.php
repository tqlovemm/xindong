<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\local\models\LocalCollectionFilesText */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="local-collection-files-text-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'member_id')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'weichat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'qq')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cellphone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weibo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'local')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\modules\local\models\LocalCollectionCount::find()->where(['not in','number',1])->all(),'number','number_name'), [
        'prompt'=>'---请选择地方啪---',
        'onchange'=>'$.post("/local/default/lists?id='.'"+$(this).val(),function(data){
                $("select#localcollectionfilestext-vip").html(data);
            });',
    ])->label("会员等级") ?>

    <?= $form->field($model, 'vip')->dropDownList(array())->label("会员等级") ?>

    <?= $form->field($model, 'address')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\modules\sm\models\Province::find()->all(),'prov_name','prov_name'))->label("地区") ?>

    <?= $form->field($model, 'birthday')->textInput()->label("年龄") ?>

    <?= $form->field($model, 'sex')->dropDownList(['0'=>"男",'1'=>'女'])->label("性别") ?>

    <?= $form->field($model, 'height')->textInput() ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'marry')->dropDownList(['0'=>"单身",'1'=>'有女朋友','2'=>'已婚'])->label("婚姻状况") ?>

    <?= $form->field($model, 'job')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hobby')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'car_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'like_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'extra')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput(['disabled'=>true]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['disabled'=>true]) ?>

    <?= $form->field($model, 'flag')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'status')->dropDownList(['0'=>"未填写",'1'=>'已经填写'])->label("填写状态") ?>

    <?= $form->field($model, 'often_go')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'annual_salary')->dropDownList(['10-20万'=>"10-20万",'20-50万'=>'20-50万','50-100万'=>'50-100万','100-300万'=>'100-300万','300-500万'=>'300-500万','500-1000万'=>'500-1000万','1000万以上'=>'1000万以上'])->label("年薪") ?>

    <?= $form->field($model, 'weima')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
