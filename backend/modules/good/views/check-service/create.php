<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\CheckService */

$this->title = 'Create Check Service';
$this->params['breadcrumbs'][] = ['label' => 'Check Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="check-service-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
