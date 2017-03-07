<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\app\models\TurnOverCardJudgeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Turn Over Card Judges';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turn-over-card-judge-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Turn Over Card Judge', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
        <?= Html::a('翻牌信息', ['/app/turn-over-card/index'], ['class' => 'btn btn-success'])?>
        <?= Html::a('觅约成功的记录', ['/app/turn-over-card-success/index'], ['class' => 'btn btn-success'])?>
        <?= Html::a('翻牌后宫', ['/app/turn-over-card-palace/index'], ['class' => 'btn btn-success'])?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'for_who',
            'num',
            'mark',
            // 'judge',
            // 'flag',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
