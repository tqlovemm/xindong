<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\weekly\models\WeeklyContent */

$this->title = 'Create Mote Content';
$this->params['breadcrumbs'][] = ['label' => 'Weekly Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weekly-content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
