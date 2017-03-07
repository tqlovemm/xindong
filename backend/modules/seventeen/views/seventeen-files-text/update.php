<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\seventeen\models\SeventeenFilesText */

$this->title = '会员编号 ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Seventeen Files Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="seventeen-files-text-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
