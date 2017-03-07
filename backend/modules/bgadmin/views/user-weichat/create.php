<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\weixin\models\UserWeichat */

$this->title = 'Create User Weichat';
$this->params['breadcrumbs'][] = ['label' => 'User Weichats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-weichat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
