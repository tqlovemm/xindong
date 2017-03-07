<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\seventeen\models\SeventeenFilesText */

$this->title = 'Create Seventeen Files Text';
$this->params['breadcrumbs'][] = ['label' => 'Seventeen Files Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seventeen-files-text-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
