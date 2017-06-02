<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\article\models\ArticleLabel */

$this->title = 'Create Article Label';
$this->params['breadcrumbs'][] = ['label' => 'Article Labels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-label-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
