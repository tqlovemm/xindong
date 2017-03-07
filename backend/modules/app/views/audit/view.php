<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\app\models\AppUserProfile */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => 'App User Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
if($model->status==1){
    $result = "<h5 class='alert alert-warning'>未审核，待审核中</h5>";
}elseif($model->status==2){
    $result = "<h5 class='alert alert-success'>已审核，审核通过</h5>";
}else{
    $result = "<h5 class='alert alert-danger'>已审核，审核不通过</h5>";
}
?>
<div class="app-user-profile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>


        <?php if($model->status==1):?>
        <?= Html::a('Pass', ['pass', 'id' => $model->user_id], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <button class="btn btn-warning" data-toggle="modal" data-target="#nopassModal">No Pass</button>
        <?php endif;?>
    </p>
    <?=$result?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_id',
            [// the owner name of the model
                 'label' => '昵称',
                 'value' => $model->user->nickname,
             ],
            'worth',
            //'file_1',
            'birthdate',
            'signature',
            'app_nopass_msg',
            //'address_2',
            //'address_3',
            'address:ntext',
            //'description:ntext',
            'is_marry',
            'mark',
            'make_friend',
            //'hobby',
            'height',
            'weight',
            'flag',
            //'updated_at',
            //'created_at',
            //'weichat',
            'status',
        ],
    ]) ?>

    <div class="row">
        <?php foreach ($images as $image):?>
        <div class="col-md-2">
            <img class="img-responsive" src="<?=$image['img_url']?>">
            <?= Html::a('Delete', ['delete-img', 'id' => $image['id']], [
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
                            <input class="form-control" required type="text" name="extra" placeholder="审核不通过原因">
                            <input type="hidden" name="id" value="<?=$model->user_id?>">
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