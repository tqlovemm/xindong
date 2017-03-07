<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\app\models\TurnOverCardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Turn Over Cards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turn-over-card-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   <p>
        <!--<?/*= Html::a('Create Turn Over Card', ['create'], ['class' => 'btn btn-success']) */?>-->
        <?= Html::a('用户翻牌后宫', ['/app/turn-over-card-palace/index'], ['class' => 'btn btn-success'])?>
        <?= Html::a('觅约成功的记录', ['/app/turn-over-card-success/index'], ['class' => 'btn btn-success'])?>
        <?= Html::a('好友评价', ['/app/turn-over-card-judge/index'], ['class' => 'btn btn-success'])?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'turn_over_time',
            'send',
            //'flag',
            //'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
