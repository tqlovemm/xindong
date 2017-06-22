<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$province = \yii\helpers\ArrayHelper::map(common\models\Province::find()->asArray()->all(),'prov_name','prov_name');
?>

<div class="thirth-files-search row">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-md-2"><?= $form->field($model, 'zid')?></div>
    <div class="col-md-2"><?= $form->field($model, 'status')->dropDownList([0=>'未发布',10=>'发布'],['prompt'=>'---请选择会员地区---']) ?></div>
    <div class="col-md-2"><?= $form->field($model, 'address')->dropDownList($province,['prompt'=>'---请选择会员地区---']) ?></div>

    <div class="form-group col-md-2">
        <label class="control-label center-block">操作</label>
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('复位', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
