<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\financial\models\FinancialWechat */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Financial Wechats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="financial-wechat-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'wechat',
            'remarks',
            'member_count',
            [
                'label' => 'created_at',
                'value' => date('Y-m-d H:i:s',$model->created_at),
            ],
            [
                'label' => 'updated_at',
                'value' => date('Y-m-d H:i:s',$model->updated_at),
            ],
            'created_by',
            'status',
            'loose_change',
        ],
    ]) ?>

</div>
