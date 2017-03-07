<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\seventeen\models\SeventeenFilesTextSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seventeen Files Texts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seventeen-files-text-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Seventeen Files Text', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'weichat',
            //'cellphone',
            'address_province',
            'address_city',
            // 'address_detail',
            // 'education',
            // 'age',
            // 'sex',
            // 'height',
            // 'weight',
            // 'cup',
            // 'job',
            // 'job_detail',
            // 'gotofield',
            // 'weibo',
            // 'id_number',
            // 'pay',
            // 'qq',
            // 'extra',
            // 'created_at',
            // 'updated_at',
            // 'flag',
             'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
