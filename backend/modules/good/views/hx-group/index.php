<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel api\modules\v8\models\HxGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hx Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hx-group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--<p>
        <?/*= Html::a('Create Hx Group', ['create'], ['class' => 'btn btn-success']) */?>
    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'g_id',
            'avatar',
            'groupname',
            /*'created_at',
            'updated_at',*/

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
