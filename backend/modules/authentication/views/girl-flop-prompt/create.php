<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\authentication\models\GirlFlopPrompt */

$this->title = 'Create Girl Flop Prompt';
$this->params['breadcrumbs'][] = ['label' => 'Girl Flop Prompts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="girl-flop-prompt-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
