<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\HxGroup */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Hx Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hx-group-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
       <!-- <?/*= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) */?>-->
        <?= Html::a('上传/更新头像', ['upload', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
       <!-- <?/*= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */?>-->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'g_id',
            'thumb',
            /*'created_at',
            'updated_at',*/
        ],
    ]) ?>
    <div>
        <img class="img-responsive" src="<?=$model['thumb']?>" style="max-width: 200px;">
    </div>
</div>
