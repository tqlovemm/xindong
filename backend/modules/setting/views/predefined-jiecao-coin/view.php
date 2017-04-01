<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\PredefinedJiecaoCoin */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '固定充值节操币', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="predefined-jiecao-coin-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确认删除吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'money',
            'giveaway',
            'status',
            'type',
            'member_type',
            'is_activity',
        ],
    ]) ?>

</div>
