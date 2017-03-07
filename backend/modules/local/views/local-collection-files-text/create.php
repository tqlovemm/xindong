<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\local\models\LocalCollectionFilesText */

$this->title = 'Create Local Collection Files Text';
$this->params['breadcrumbs'][] = ['label' => 'Local Collection Files Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="local-collection-files-text-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
