<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\AppPush */

$this->title = 'Create App Push';
$this->params['breadcrumbs'][] = ['label' => 'App Pushes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-push-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
