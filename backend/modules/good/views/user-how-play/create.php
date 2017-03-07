<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\UserHowPlay */

$this->title = 'Create User How Play';
$this->params['breadcrumbs'][] = ['label' => 'User How Plays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-how-play-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
