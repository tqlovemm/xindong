<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\financial\models\FinancialWechatMemberIncrease */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Financial Wechat Member Increases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="financial-wechat-member-increase-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'wechat_id' => $model->wechat_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'wechat_id' => $model->wechat_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'wechat_id',
            'increase_boy_count',
            'increase_girl_count',
            'total_count',
            'reduce_count',
            'created_at',
            'updated_at',
            'created_by',
            'loose_change',
            'join_count',
        ],
    ]) ?>

</div>
