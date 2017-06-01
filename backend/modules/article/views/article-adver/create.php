<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\article\models\ArticleAdver */

$this->title = '情话广告添加';
$this->params['breadcrumbs'][] = ['label' => 'Article Advers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-adver-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
