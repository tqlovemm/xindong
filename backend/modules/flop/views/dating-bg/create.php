<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\dating\models\Dating */

$this->title = 'Create Dating';
$this->params['breadcrumbs'][] = ['label' => 'Datings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dating-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
