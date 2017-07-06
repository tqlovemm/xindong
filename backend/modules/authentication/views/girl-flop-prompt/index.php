<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\authentication\models\GirlFlopPromptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '女生认证提示';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="girl-flop-prompt-index">

    <h1>女生认证提示</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'content',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
