<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\note\models\VoteSignInfo */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vote Sign Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vote-sign-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'openid' => $model->openid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'openid' => $model->openid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Pass', ['pass', 'id' => $model->id, 'openid' => $model->openid], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Are you sure you want to pass this item?',
                'method' => 'post',
            ],
        ]) ?>
        <button class="btn btn-warning" data-toggle="modal" data-target="#nopassModal">No Pass</button>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            //'openid',
            'number',
            'declaration',
            'sex',
            'extra',
            'vote_count',
            'created_at:datetime',
            //'updated_at',
            'status',
        ],
    ]) ?>

    <div class="row">
        <?php foreach ($img as $item): ?>
            <div class="col-md-2">
                <img class="img-responsive" src="http://13loveme.com/<?=$item['img']?>">
                <?= Html::a('Delete', ['delete-img', 'id' => $item['id']], [
                    'class' => 'btn btn-danger',
                    'data' => [

                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        <?php endforeach;?>

    </div>

</div>



<!-- 模态框（Modal） -->
<div class="modal fade" id="nopassModal" tabindex="-1" role="dialog" aria-labelledby="nopassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    审核不通过
                </h4>
            </div>
            <div class="modal-body">
                <form action="no-pass" method="get" class="form-horizontal" role="form">
                    <div class="form-group">
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="extra" placeholder="审核不通过原因">
                            <input type="hidden" name="id" value="<?=$model->id?>">
                            <input type="hidden" name="openid" value="<?=$model->openid?>">
                        </div>
                        <div class="col-md-2">
                            <input class="btn btn-default" type="submit" value="提交">
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>