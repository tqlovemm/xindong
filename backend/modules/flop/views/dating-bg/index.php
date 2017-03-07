<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\flop\models\DatingBgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Datings';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::a('十三平台女生会员跟踪列表', ['/bgadmin/girl-default'], ['class' => 'btn btn-primary']) ?>
<div class="dating-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            //'title2',
            //'title3',
            //'content',
            // 'introduction',
            'cover_id',
            [
                'attribute' => 'created_at',
                'label' => '地方啪',
                'value' => function ($data) {
                    return date('Y-m-d H:i:s',$data->created_at);
                }
            ],
            //'created_at',
            // 'updated_at',
            // 'created_by',
            // 'enable_comment',
            // 'status',
            // 'url:url',
            'number',
             'worth',
            // 'expire',
            // 'full_time:datetime',
            // 'platform',
            // 'flag',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
