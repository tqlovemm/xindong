<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\collecting\models\Collecting17FilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Collecting17 Files Texts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collecting17-files-text-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                'address_province',
                'weichat',
                'cellphone',
                'address_province',
                'address_city',
                'status',
                'updated_at:datetime',
                ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update} {delete}'],
            ],
        ]); ?>
</div>
