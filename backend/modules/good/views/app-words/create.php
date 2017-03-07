<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\AppWords */

$this->title = 'Create App Words';
$this->params['breadcrumbs'][] = ['label' => 'App Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-words-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
