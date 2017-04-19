<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\financial\models\FinancialWechatMemberIncrease */

$this->title = 'Update Financial Wechat Member Increase: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Financial Wechat Member Increases', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'wechat_id' => $model->wechat_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="financial-wechat-member-increase-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'wechat'=>$wechat
    ]) ?>

</div>
