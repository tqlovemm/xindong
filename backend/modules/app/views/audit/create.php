<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\app\models\AppUserProfile */

$this->title = 'Create App User Profile';
$this->params['breadcrumbs'][] = ['label' => 'App User Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-user-profile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
