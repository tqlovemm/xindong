<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\app\models\AppUserProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'App User Profiles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-user-profile-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create App User Profile', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user_id',
            //'number',
            'worth',
            //'file_1',
            'birthdate',
            'signature',
            //'address_1',
            //'address_2',
            //'address_3',
            //'address:ntext',
            //'description:ntext',
            'is_marry',
            'mark',
            'make_friend',
            //'hobby',
            'height',
            'weight',
            //'flag',
            //'updated_at',
            //'created_at',
            //'weichat',
            'status',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],
        ],
    ]); ?>

</div>
