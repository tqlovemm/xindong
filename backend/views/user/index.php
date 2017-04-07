<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'User',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            ['class' => 'yii\grid\ActionColumn'],
            [
                'attribute' => 'number',
                'label' => '会员编号',
                'value' => function ($data) {
                    $user = \backend\models\User::getNumber($data->id);
                    return $user;
                }

            ],
            'id',
            'cid',
            'username',
            'nickname',
            //'password_hash',
           //'password_reset_token',
            [
                'attribute' => 'groupid',
                'label' => '会员等级',
                'value' => function ($data) {
                    if($data->groupid==1){
                        $vip = "1-网站会员";
                    }elseif($data->groupid==2){
                        $vip = "2-普通会员";
                    }elseif($data->groupid==3){
                        $vip = "3-高端会员";
                    }elseif($data->groupid==4){
                        $vip = "4-至尊会员";
                    }elseif($data->groupid==5){
                        $vip = "5-私人定制";
                    }else{
                        $vip = "未知错误";
                    }

                    return $vip;
                }

            ],
            //'identify',
            'cellphone',
            'email:email',
            //'status',
            //'role',
            [
                'attribute' => 'sex',
                'label' => '性别',
                'value' => function ($data) {
                    if($data->sex==0){
                        $vip = "0-男";
                    }elseif($data->sex==1){
                        $vip = "1-女";
                    }else{
                        $vip = "未知错误";
                    }

                    return $vip;
                }

            ],
            //'salary',
            //'weibo_num',
            //'job',
            //'car',
            //'cup',
             //'created_at:datetime',
             //'updated_at:datetime',
             //'avatar',

        ],
    ]); ?>

</div>
