<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\weekly\models\WeeklyContent */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Weekly Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weekly-content-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->cid], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cid',
            'website_id',
            'name',
            'path:image',
            'created_at',
            'created_by',
        ],
    ]) ?>

</div>
