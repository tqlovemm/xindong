<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\PredefinedJiecaoCoin */

$this->title = '创建固定充值节操币';
$this->params['breadcrumbs'][] = ['label' => '固定充值节操币', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="predefined-jiecao-coin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
