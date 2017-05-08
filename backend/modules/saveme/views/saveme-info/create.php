<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\saveme\models\SavemeInfo */

$this->title = 'Create Saveme Info';
$this->params['breadcrumbs'][] = ['label' => 'Saveme Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saveme-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
