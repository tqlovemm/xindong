<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\seventeen\models\SeventeenFilesImg */

$this->title = 'Update Seventeen Files Img: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Seventeen Files Imgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="seventeen-files-img-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
