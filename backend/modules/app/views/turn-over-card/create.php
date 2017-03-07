<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\app\models\TurnOverCard */

$this->title = 'Create Turn Over Card';
$this->params['breadcrumbs'][] = ['label' => 'Turn Over Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turn-over-card-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
