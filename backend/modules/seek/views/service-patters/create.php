<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\seek\models\ServicePatters */

$this->title = 'Create Service Patters';
$this->params['breadcrumbs'][] = ['label' => 'Service Patters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-patters-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
