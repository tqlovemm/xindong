<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\weixin\models\UserWeichat */

$this->title = $model->openid;
$this->params['breadcrumbs'][] = ['label' => 'User Weichats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-weichat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->openid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->openid], [
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
            'openid',
            'number',
            'nickname',
            'headimgurl:image',
            'address',
        ],
    ]) ?>

</div>
