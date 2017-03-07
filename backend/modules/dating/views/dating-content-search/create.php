<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\dating\models\DatingContent */

$this->title = 'Create Dating Content';
$this->params['breadcrumbs'][] = ['label' => 'Dating Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dating-content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
