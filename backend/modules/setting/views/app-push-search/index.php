<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\setting\models\AppPushSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerCss('

    td{word-wrap:break-word;word-break:break-all;}
');
$this->title = 'App Pushes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-push-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create App Push', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'status',
            'cid',
            'title',
            'msg',
             'extras',
             'platform',
             'response',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
