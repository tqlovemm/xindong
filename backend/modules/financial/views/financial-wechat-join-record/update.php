<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\financial\models\FinancialWechatJoinRecord */

$this->title = 'Update Financial Wechat Join Record: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Financial Wechat Join Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'wechat_id' => $model->wechat_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="financial-wechat-join-record-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'wechat'=>$wechat,'province'=>$province
    ]) ?>

</div>
