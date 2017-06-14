<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\apps\models\FormThreadCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Form Thread Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-thread-comments-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Form Thread Comments', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'comment',
                'format'=>'raw',
                'label' => '评价内容',
                'value' => function ($data) {
                    return $data->comment;

                }
            ],

            [
                'attribute' => '评价人',
                'format'=>'raw',
                'label' => '评价人',
                'value' => function ($data) {
                    $user = \api\modules\v11\models\User::findOne($data->first_id);
                    if(!empty($user)){
                        return !empty($user->nickname)?$user->nickname:$user->username;
                    }else{
                        return "评价人已被删除";
                    }

                }
            ],
            [
                'attribute' => '被评人',
                'format'=>'raw',
                'label' => '被评人',
                'value' => function ($data) {
                    $user = \api\modules\v11\models\User::findOne($data->second_id);
                    if(!empty($user)){
                        return !empty($user->nickname)?$user->nickname:$user->username;
                    }else{
                        return "";
                    }

                }
            ],
            [
                'attribute' => '帖子内容',
                'format'=>'raw',
                'label' => '帖子内容',
                'value' => function ($data) {
                    $thread = \api\modules\v11\models\FormThread::findOne($data->thread_id);
                    return !empty($thread->content)?\yii\myhelper\Helper::truncate_utf8_string($thread->content,25):"图片贴";
                }
            ],
            [
                'attribute' => '评价时间',
                'format'=>'raw',
                'label' => '评价时间',
                'value' => function ($data) {
                    return date('Y/m/d H:i:s',$data->created_at);
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
