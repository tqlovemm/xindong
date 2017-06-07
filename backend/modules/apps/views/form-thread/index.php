<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\apps\models\FormThreadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Form Threads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-thread-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('管理员发帖', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'wid',
            [
                'label'=>'会员名',
                'attribute' => 'username',
                'value' => function($model) {

                    if(($username = User::findOne(['username'=>$model->username]))==null){
                        $username = User::findOne(['id'=>$model->user_id])->username;
                    }else{
                        $username = $username->username;
                    }
                        return $username;
                    },
            ],
            'user_id',
            'content:ntext',
            'tag',
            [
                'attribute' => 'created_at',
                'value' => function($model) {
                    return date('Y-m-d H:i:s',$model->created_at);
                },
            ],
            [
                'attribute' => 'sex',
                'value' => function($model) {
                    if($model->sex == 0){
                        return '男';
                    }elseif($model->sex == 1){
                        return '女';
                    }else{
                        return '版规广告';
                    }
                },
                'filter' => [
                    0 => '男',
                    1 => '女',
                ]
            ],
            // 'lat_long',
            // 'address',
            // 'updated_at',

            [
                'attribute' => 'is_top',
                'value' => function($model) {
                    return ($model->is_top == 0)?'非置顶贴':'置顶贴';
                },
                'filter' => [
                    0 => '非置顶贴',
                    1 => '置顶贴',
                ]
            ],
            [
                'attribute' => 'type',
                'value' => function($model) {
                    if($model->type == 0){
                        return '帖子';
                    }elseif($model->type == 1){
                        return '广告';
                    }else{
                        return '版规';
                    }

                },
                'filter' => [
                    0 => '帖子',
                    1 => '广告',
                    2 => '版规',
                ]
            ],
            // 'read_count',
            // 'thumbs_count',
            // 'comments_count',
            // 'admin_count',
            // 'total_score',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return ($model->status == 10)?'可见贴':'不可见贴';
                },
                'filter' => [
                    0 => '不可见贴',
                    10 => '可见贴',
                ]
            ],
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
