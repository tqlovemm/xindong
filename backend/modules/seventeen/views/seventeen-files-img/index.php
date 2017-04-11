<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\seventeen\models\SeventeenFilesImgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seventeen Files Imgs';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="seventeen-files-img-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',
            'text_id',
            [
                'format' => 'raw',
                'label' => '上传图片',
                'value' => function ($data) {
                    $pre_url = Yii::$app->params['qiniushiqi'];
                    return "<img style='width: 100px;' src='$pre_url$data->img'>";
                }

            ],
            'type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
