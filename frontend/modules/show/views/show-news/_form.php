<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\show\models\ShowNews */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="show-news-form">

    <form action="http://13loveme.com/show/show-news/create" method="post" name="image" enctype="multipart/form-data">

        <input class="form-control" name="content" type="text">

        <input type="file" name="image[]">

        <input class="btn btn-danger" type="submit" name="submit">

    </form>
<!--    <?php /*$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); */?>

    <?/*= $form->field($model, 'content')->textInput() */?>
    <?/*= $form->field($model, 'path')->fileInput() */?>


    <div class="form-group">
        <?/*= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) */?>
    </div>

    --><?php /*ActiveForm::end(); */?>

</div>
