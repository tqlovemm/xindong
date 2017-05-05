<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\male\models\MaleInfoText */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Male Info Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="male-info-text-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除吗?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('审核通过', ['pass', 'id' => $model->id], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => '确定审核通过吗?',
                'method' => 'post',
            ],
        ]) ?>
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">审核不通过</button>
    </p>

<div class="row">
    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">档案信息</h3>
                <div class="box-tools pull-right"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button></div>
            </div>
            <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'wechat',
                'cellphone',
                'email:email',
                'age',
                'car_type',
                'annual_salary',
                'height',
                'weight',
                'marry',
                'job',
                'offten_go',
                'hobby',
                'like_type',
                'remarks',
                'coin',
                'province',
                'city',
                'vip',
                'created_at:datetime',
                'updated_at:datetime',
                'flag',
                'status',
                'created_by',
                'handler',
                'no_pass_reason',
            ],
        ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">档案照</h3>
                <div class="box-tools pull-right"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button></div>
            </div>
            <div class="box-body">
                <?php foreach($model->img as $item):?>
                <div class="pull-left" style="position: relative;border: 1px solid #ddd;margin: 5px;">
                    <?php if($item['type']==1){
                        echo "<span style='position: absolute;top:30%;left:30%;background-color: rgba(255, 0, 0, 0.60);width: 100px;height: 100px;border-radius: 50%;line-height: 100px;text-align: center;color:#fff;font-size: 20px;'>头像</span>";
                    }?>
                    <img src="http://ooqyxp14h.bkt.clouddn.com/<?=$item['img']?>?imageView2/1/w/200/h/200">
                    <div class="text-center clear-fix" style="margin-top: 10px;margin-bottom: 10px;">
                        <?=Html::a('删除',['delete-img','id'=>$item['id']],[
                            'class'=>'btn-sm btn-danger','data' => [
                            'confirm' => '确定删除吗?',
                            'method' => 'post',
                        ],])?>
                        <?=Html::a('左转',['left'],['class'=>'btn-sm btn-primary'])?>
                        <?=Html::a('右转',['right'],['class'=>'btn-sm btn-primary'])?>
                        <?=Html::a('头像',['set-avatar','id'=>$item['id']],['class'=>'btn-sm btn-success'])?>
                    </div>

                </div>
                <?php endforeach;?>
            </div>
        </div>
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">微信二维码</h3>
                <div class="box-tools pull-right"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button></div>
            </div>
            <div class="box-body">
                <?php if(!empty($model->wm['img'])):?>
                <div class="pull-left" style="position: relative;border: 1px solid #ddd;margin: 5px;">
                    <img src="http://ooqyxp14h.bkt.clouddn.com/<?=$model->wm['img']?>?imageView2/1/w/200/h/200">
                    <div class="text-center clear-fix" style="margin-top: 10px;margin-bottom: 10px;">
                        <?=Html::a('删除',['delete-img','id'=>$model->wm['id']],[
                            'class'=>'btn-sm btn-danger',
                            'data' => [
                                'confirm' => '确定删除吗?',
                                'method' => 'post',
                            ],])?>
                        <?=Html::a('左转',['left'],['class'=>'btn-sm btn-primary'])?>
                        <?=Html::a('右转',['right'],['class'=>'btn-sm btn-primary'])?>
                    </div>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <?= Html::beginForm('no-pass?id=69') ?>
                <div class="box-body">
                    <div class="form-group">
                        <?= Html::label('审核不通过原因', 'no_pass_reason') ?>
                        <?= Html::textarea('no_pass_reason', $model->no_pass_reason, ['class' => 'form-control']) ?>
                        <?= Html::hiddenInput('status', 3, ['class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="box-footer">
                    <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                </div>
                <?= Html::endForm(); ?>
            </div>
        </div>
    </div>
</div>