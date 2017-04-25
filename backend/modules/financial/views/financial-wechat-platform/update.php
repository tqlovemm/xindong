<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\financial\models\FinancialWechatPlatform */

$this->title = 'Update Financial Wechat Platform: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Financial Wechat Platforms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="financial-wechat-platform-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
