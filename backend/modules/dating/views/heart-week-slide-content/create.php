<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\dating\models\HeartweekSlideContent */

$this->title = 'Create Heartweek Slide Content';
$this->params['breadcrumbs'][] = ['label' => 'Heartweek Slide Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="heartweek-slide-content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
