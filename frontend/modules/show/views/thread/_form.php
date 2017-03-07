<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="thread-form">
    <?php if (!Yii::$app->user->isGuest) :?>
        <?php $form = ActiveForm::begin([
            'action'=>'/index.php/forum/forum/views',
            'method'=>'post',

        ]); ?>

        <?= $form->field($model, 'content')->widget('shiyang\umeditor\UMeditor', [
            'clientOptions' => [
                'initialFrameHeight' => 200,
                'toolbar' => [
                    '| emotion image |',
                ],
            ]
        ])->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Push Board') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'autocomplete'=>'off']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    <?php else: ?>
        <h3>Welcom to <?= Html::encode($forumName); ?></h3>
    <?php endif; ?>
</div>