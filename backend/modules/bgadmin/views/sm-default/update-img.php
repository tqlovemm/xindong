<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\SmadminMember */

$this->title = 'Update Smadmin Member: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bgadmin Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$pre_url = Yii::$app->params['localandsm'];
?>
<div class="bgadmin-member-form">

    <a href="<?=$pre_url.$model->path?>" data-lightbox="s" data-title="<?=$model->content?>">
        <img style="max-width: 300px;" src="<?=$pre_url.$model->path?>">
    </a>
    <h5>上传人：<?=$model->created_by?></h5>
    <h5>上传时间：<?=date('Y-m-d H:i:s',$model->created_at)?></h5>
    <p>图片描述：<?=$model->content?></p>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'content')->textarea(['maxlength' => true])->label('修改图片描述') ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>