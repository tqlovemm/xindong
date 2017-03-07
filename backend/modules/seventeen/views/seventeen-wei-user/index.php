<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\seventeen\models\SeventeenWeiUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '十七微信会员';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seventeen-wei-user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //echo Html::a('Create Seventeen Wei User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'nickname',
            //'openid',
            'address',
            'status',
            //'headimgurl:image',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
