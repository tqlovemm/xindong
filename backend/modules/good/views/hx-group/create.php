<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\HxGroup */

$this->title = 'Create Hx Group';
$this->params['breadcrumbs'][] = ['label' => 'Hx Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hx-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
