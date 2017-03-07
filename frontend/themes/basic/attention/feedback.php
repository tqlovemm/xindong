<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title='意见投诉';

?>


    <div class="row">
        <div class="col-lg-2">
             <?= $this->render('./attention-left')?>
        </div>

        <div class="col-md-10">
            <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title"><?=\yii\helpers\Html::encode($this->title)?></h3>

            </div>
            <div class="panel-body">


                <?php $form = ActiveForm::begin([

                    'action' => ['attention/feedback'],
                    'method'=>'post',

                ])?>


                <?=$form->field($model, 'title')->textInput(['maxlength' =>125,'placeholder'=>'平台会员请填写编号，客服会尽快联系您'])->label('原因') ?>
                <?=$form->field($model, 'content')->textarea(['rows'=>5]) ?>
                <?php
                    if(!empty(Yii::$app->user->identity->username)):
                ?>
                <?=Html::activeHiddenInput($model,'created_by',['value'=>Yii::$app->user->identity->username])?>

                <?php endif; ?>

                <?=Html::activeHiddenInput($model,'created_at',['value'=>time()])?>
                <?= Html::submitButton('提交', ['class'=>'btn btn-primary','name' =>'submit-button']) ?>
                <?= Html::resetButton('重置', ['class'=>'btn btn-primary','name' =>'submit-button']) ?>

                <?php $form = ActiveForm::end()?>

            </div>

        </div>
        </div>
    </div>


