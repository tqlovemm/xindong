<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "所有注册会员";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', ['modelClass' => 'User',]), ['create'], ['class' => 'btn btn-success']) ?>
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
            [
                'attribute' => 'groupid',
                'label' => '会员等级',
                'value' => function ($data) {
                    return \common\components\Vip::vip($data->groupid);
                }
            ],
            'cellphone',
            'email:email',
            [
                'attribute' => 'sex',
                'label' => '性别',
                'value' => function ($data) {
                    return \common\components\Vip::sex($data->sex);
                }
            ],
        ],
    ]); ?>

</div>
