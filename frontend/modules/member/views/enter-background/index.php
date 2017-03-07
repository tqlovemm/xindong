<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\member\models\EnterTheBackgroundSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Enter The Backgrounds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="enter-the-background-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建可登录后台IP', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('前往后台', 'http://13loveme.com:82', ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'allow_ip',
            //'forbid_ip',
            'created_at:datetime',
            'updated_at:datetime',
            'created_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
