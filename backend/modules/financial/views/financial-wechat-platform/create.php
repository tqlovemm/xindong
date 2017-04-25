<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\financial\models\FinancialWechatPlatform */

$this->title = 'Create Financial Wechat Platform';
$this->params['breadcrumbs'][] = ['label' => 'Financial Wechat Platforms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="financial-wechat-platform-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
