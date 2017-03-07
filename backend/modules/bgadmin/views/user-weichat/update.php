<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\weixin\models\UserWeichat */

$this->title = 'Update User Weichat: ' . ' ' . $model->openid;
$this->params['breadcrumbs'][] = ['label' => 'User Weichats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->openid, 'url' => ['view', 'id' => $model->openid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-weichat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
