<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\active\models\NewYearGood */

$this->title = 'Create New Year Good';
$this->params['breadcrumbs'][] = ['label' => 'New Year Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="new-year-good-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
