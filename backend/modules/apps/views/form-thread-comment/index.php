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

            'comment_id',
            'thread_id',
            'first_id',
            'second_id',
            'comment:ntext',
            // 'flag',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
