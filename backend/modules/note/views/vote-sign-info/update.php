<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\note\models\VoteSignInfo */

$this->title = 'Update Vote Sign Info: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vote Sign Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'openid' => $model->openid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vote-sign-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
