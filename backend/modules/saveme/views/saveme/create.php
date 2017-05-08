<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\saveme\models\Saveme */

$this->title = 'Create Saveme';
$this->params['breadcrumbs'][] = ['label' => 'Savemes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saveme-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
