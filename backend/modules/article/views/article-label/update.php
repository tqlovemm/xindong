<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\article\models\ArticleLabel */

$this->title = 'Update Article Label: ' . ' ' . $model->lid;
$this->params['breadcrumbs'][] = ['label' => 'Article Labels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->lid, 'url' => ['view', 'id' => $model->lid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="article-label-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
