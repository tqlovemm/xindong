<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\active\models\NewYear */

$this->title = 'Create New Year';
$this->params['breadcrumbs'][] = ['label' => 'New Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="new-year-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
