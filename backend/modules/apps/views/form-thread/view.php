<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model api\modules\v11\models\FormThread */

$this->title = $model->wid;
$this->params['breadcrumbs'][] = ['label' => 'Form Threads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-thread-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->wid], ['class' => 'btn btn-primary']) ?>
        <a href="<?= Url::toRoute(['upload', 'id' => $model->wid]) ?>" class="btn btn-primary">
            <span class="glyphicon glyphicon-plus"></span> 上传帖子图片
        </a>
        <?= Html::a('Delete', ['delete', 'id' => $model->wid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'wid',
            'user_id',
            'content:ntext',
            'tag',
            'sex',
            'lat_long',
            'address',
            'updated_at',
            'created_at',
            'is_top',
            'type',
            'read_count',
            'thumbs_count',
            'comments_count',
            'admin_count',
            'total_score',
            'status',
        ],
    ]) ?>

</div>
<div class="row">
    <?php foreach ($model->cover as $img):?>
    <div class="col-md-2">
        <img class="img-responsive" src="<?=$img->img_path?>">
        <?= Html::a('删除', ['delete-img', 'id' => $img->img_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <?php endforeach;?>
</div>
<hr>
<h4>评价区</h4>
<ul class="list-group">
    <?php foreach ($model->comment as $com):?>
    <li class="list-group-item">
        <?=$com->comment?><?=date('Y-m-d H:i:s',$com->created_at)?>
        <?= Html::a('删除', ['delete-comment', 'cid' => $com->comment_id], [
            'class' => 'btn-sm btn-warning',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </li>
    <?php endforeach;?>
</ul>
<h4>点赞区</h4>
<ul class="list-group">
    <?php foreach ($model->thumbs as $thumb):
        $user = \api\modules\v11\models\User::findOne($thumb->user_id);
        if(!empty($user)){

            $username = (empty($user->nickname))?$user->username:$user->nickname;
        }else{
            $username = '该会员已经被删除';
        }

        ?>
        <li class="list-group-item">
            <?=$username?>：<?=date('Y-m-d H:i:s',$thumb->created_at)?>
            <?= Html::a('删除', ['delete-thumbs', 'tid' => $thumb->thumbs_id], [
                'class' => 'btn-sm btn-warning',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </li>
    <?php endforeach;?>
</ul>