<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\collecting\models\AutoJoinRecord */

$this->title = 'Create Auto Join Record';
$this->params['breadcrumbs'][] = ['label' => 'Auto Join Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-join-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
