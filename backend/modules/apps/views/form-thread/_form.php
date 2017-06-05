<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model api\modules\v11\models\FormThread */
/* @var $form yii\widgets\ActiveForm */
//thumbs_count*0.3+comments_count*0.5+admin_count*0.1+read_count*0.1
?>

<div class="form-thread-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tag')->dropDownList($tagList) ?>

    <?= $form->field($model, 'sex')->dropDownList([0=>'男生',1=>'女生']) ?>

    <?= $form->field($model, 'is_top')->dropDownList([0=>'不置顶',1=>'置顶']) ?>

    <?= $form->field($model, 'type')->dropDownList([0=>'正常帖子',1=>'广告',2=>'版规']) ?><!--//类型：0/正常帖子，1/广告，2/版规-->

    <?= $form->field($model, 'read_count')->textInput()->label('阅读数,权重0.1') ?>

    <?= $form->field($model, 'thumbs_count')->textInput()->label('点赞数,权重0.3')  ?>

    <?= $form->field($model, 'comments_count')->textInput()->label('评论数,权重0.5')  ?>

    <?= $form->field($model, 'total_score')->textInput()->label('帖子总分，每10秒刷新一次决定帖子排名')  ?>

    <?= $form->field($model, 'status')->dropDownList([10=>'正常显示',0=>'隐藏'])->label('帖子状态')  ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
