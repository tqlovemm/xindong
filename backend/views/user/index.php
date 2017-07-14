<?php
use yii\grid\GridView;
use common\components\Vip;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "所有注册会员";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn'],
            [
                'attribute' => 'number',
                'label' => '会员编号',
                'value' => function ($data) {
                    $user = User::getNumber($data->id);
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
                    return Vip::vip($data->groupid);
                },
                'filter' => [
                    0 => '网站会员',
                    1 => '包月会员',
                    2 => '普通会员',
                    3 => '高端会员',
                    4 => '至尊会员',
                    5 => '私人定制',
                ]
            ],
            'cellphone',
            'email:email',
            [
                'attribute' => 'sex',
                'label' => '性别',
                'value' => function ($data) {
                    return Vip::sex($data->sex);
                },
                'filter' => [
                    0 => '男',
                    1 => '女'
                ]
            ],
        ],
    ]); ?>

</div>
