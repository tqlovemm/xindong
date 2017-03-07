<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\sm\models\SmCollectionFilesText */

$this->title = 'Create Sm Collection Files Text';
$this->params['breadcrumbs'][] = ['label' => 'Sm Collection Files Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sm-collection-files-text-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
