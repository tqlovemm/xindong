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
                }
            ],
            'cellphone',
            'email:email',
            [
                'attribute' => 'sex',
                'label' => '性别',
                'value' => function ($data) {
                    return Vip::sex($data->sex);
                }
            ],
        ],
    ]); ?>

</div>
