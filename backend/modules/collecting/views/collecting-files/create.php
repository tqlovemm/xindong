<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Collecting17FilesText */

$this->title = 'Create Collecting17 Files Text';
$this->params['breadcrumbs'][] = ['label' => 'Collecting17 Files Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collecting17-files-text-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
