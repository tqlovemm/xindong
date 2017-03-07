<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\member\models\UserBgRecord */

$this->title = 'Create User Bg Record';
$this->params['breadcrumbs'][] = ['label' => 'User Bg Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-bg-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
