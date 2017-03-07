<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ThirthFiles */

$this->title = 'Create App Files';
$this->params['breadcrumbs'][] = ['label' => 'Thirth Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thirth-files-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
