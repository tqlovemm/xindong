<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\sm\models\SmCollectionCount */

$this->title = 'Create Sm Collection Count';
$this->params['breadcrumbs'][] = ['label' => 'Sm Collection Counts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sm-collection-count-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
