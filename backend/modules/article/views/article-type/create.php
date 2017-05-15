<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\article\models\ArticleType */

$this->title = 'Create Article Type';
$this->params['breadcrumbs'][] = ['label' => 'Article Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
