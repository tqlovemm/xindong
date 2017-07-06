<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\authentication\models\GirlFlopPrompt */

$this->title = 'Update Girl Flop Prompt: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Girl Flop Prompts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="girl-flop-prompt-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
