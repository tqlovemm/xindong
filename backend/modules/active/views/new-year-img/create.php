<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\active\models\NewYearImg */

$this->title = 'Create New Year Img';
$this->params['breadcrumbs'][] = ['label' => 'New Year Imgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="new-year-img-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
