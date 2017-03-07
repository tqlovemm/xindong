<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\good\models\AppWordsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'App Words';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-words-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create App Words', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
        <a href="<?= Url::toRoute('/good/app-words-comment/index')?>" style="font-size: 14px;text-align: center;color: white;display:block;background-color: #00a65a;width: 118px;height: 40px;line-height: 40px;border-radius: 4px;">
           查看评论
        </a>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',

            'user_id',
            [
                'attribute' => 'username',
                'label' => '用户名',
                'value' => function ($data) {
                    $user = \backend\models\User::getUsername($data->user_id);
                    return $user;
                }

            ],
            'address',
            'content:ntext',
            'img',

            // 'created_at',
            // 'updated_at',
            // 'flag',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
