<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\show\models\Seeks */

$this->title = 'Create Seeks';
$this->params['breadcrumbs'][] = ['label' => 'Seeks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seeks-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
