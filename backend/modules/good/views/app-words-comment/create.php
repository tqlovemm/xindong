<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\AppWordsComment */

$this->title = 'Create App Words Comment';
$this->params['breadcrumbs'][] = ['label' => 'App Words Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-words-comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
