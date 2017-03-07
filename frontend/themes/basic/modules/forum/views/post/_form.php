<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>
<section class="post-area">
    <div class="row">
        <div class="post-form col-md-12">
            <?php if (!Yii::$app->user->isGuest) :?>
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'content')->widget('shiyang\umeditor\UMeditor', [
                    'clientOptions' => [
                        'initialFrameHeight' =>70,
                        'toolbar' => [
                            '| emotion image |',
                        ],
                    ]
                ])->label(false) ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Reply'), ['class' => 'btn btn-success pull-right']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            <?php else: ?>
                <h3><?= Yii::t('app', 'Please login to leave a comment.') ?></h3>
                <?= Html::a(Yii::t('app', 'Log in'), ['/site/login'], ['class' => 'btn btn-success']) ?>
            <?php endif; ?>
        </div>
    </div>
</section>
