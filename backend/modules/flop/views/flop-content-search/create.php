<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\flop\models\FlopContent */

$this->title = 'Create Flop Content';
$this->params['breadcrumbs'][] = ['label' => 'Weekly Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weekly-content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
