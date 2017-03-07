<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\dating\models\DatingVipSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dating Vips';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dating-vip-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dating Vip', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user_id',
            [
                'attribute'=>'编号',
                'label'=>'会员编号',
                'value'=>function($data){
                    return \backend\models\User::getNumber($data->user_id);
                },
            ],
            [
                'attribute'=>'等级',
                'label'=>'会员等级',
                'value'=>function($data){
                    $vip =  \backend\models\User::getVip($data->user_id);
                    if($vip==2){
                        return "普通会员";
                    } elseif($vip==3){
                        return "高端会员";
                    } elseif($vip==4){
                        return "至尊会员";
                    }else{
                        return "私人定制";
                    }
                },
            ],
            [
                'attribute'=>'时间',
                'label'=>'时间',
                'value'=>function($data){
                    return date('Y-m-d H:i:s',$data->created_at);
                }
            ],
            [
                'attribute'=>'coin',
                'label'=>'消费节操币',
                'value'=>function($data){
                    return $data->coin;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
