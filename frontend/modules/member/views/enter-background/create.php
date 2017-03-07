<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\member\models\EnterTheBackground */

$this->title = 'Create Enter The Background';
$this->params['breadcrumbs'][] = ['label' => 'Enter The Backgrounds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="enter-the-background-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
