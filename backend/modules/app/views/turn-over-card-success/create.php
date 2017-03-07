<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\app\models\TurnOverCardSuccess */

$this->title = 'Create Turn Over Card Success';
$this->params['breadcrumbs'][] = ['label' => 'Turn Over Card Successes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turn-over-card-success-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
