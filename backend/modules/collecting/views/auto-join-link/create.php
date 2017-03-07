<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\collecting\models\AutoJoinLink */

$this->title = 'Create Auto Join Link';
$this->params['breadcrumbs'][] = ['label' => 'Auto Join Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-join-link-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
