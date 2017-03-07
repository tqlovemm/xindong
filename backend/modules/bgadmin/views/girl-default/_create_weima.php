<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\ScanWeimaDetail */
/* @var $form ActiveForm */
?>
<div class="create_weima">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'customer_service') ?>
        <?= $form->field($model, 'account_manager') ?>
        <?= $form->field($model, 'description') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- _create_weima -->
<?php if(!empty($weima)):?>
    <?=$weima?>
<?php endif;?>
