<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\CheckService */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Check Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="check-service-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('上传头像', ['upload', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
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
            'number',
            'nickname',
            'flag',
            'created_at',
            'updated_at',
        ],
    ]) ?>
</div>
<div><img src="<?=Yii::$app->params['threadimg'].$model->avatar?>" style="width: 200px;"></div>