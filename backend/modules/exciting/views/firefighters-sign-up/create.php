<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\exciting\models\FirefightersSignUp */

$this->title = 'Create Firefighters Sign Up';
$this->params['breadcrumbs'][] = ['label' => 'Firefighters Sign Ups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="firefighters-sign-up-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
