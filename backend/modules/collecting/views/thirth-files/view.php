<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Thirth Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$pre_url = Yii::$app->params['imagetqlmm'];
?>
<div class="thirth-files-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(!in_array(Yii::$app->user->id,[13921,10184,10174])):?>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif;?>
        <?php if($model->status==1):?>
        <?= Html::a('审核通过', ['pass', 'id' => $model->id], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Are you sure you want to pass this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('审核不通过', ['no-pass', 'id' => $model->id], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Are you sure you want to no pass this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif;?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'weichat',
            'cellphone',
            'weibo',
            'address',
            'age:datetime',
            'sex',
            'height',
            'weight',
            'marry',
            'job',
            'hobby',
            'like_type',
            'car_type',
            'extra',
            'status',
            'often_go',
            'annual_salary',
            'qq',
        ],
    ]) ?>

    <div class="row">
        <?php foreach ($img as $item):?>
            <div class="col-md-2">
                <img class="img-responsive" src="<?=$pre_url.$item['thumb_img']?>">
                <a class="btn btn-primary" onclick="rotate_img(<?=$item['id']?>,1,this)">顺时针</a>
                <a class="btn btn-primary" onclick="rotate_img(<?=$item['id']?>,2,this)">逆时针</a>
                <?php if(!in_array(Yii::$app->user->id,[13921,10184])):?>
                    <?= Html::a('Delete', ['delete-img', 'id' => $item['id']], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>

                <?php endif;?>
            </div>
        <?php endforeach;?>
    </div>
</div>
<script>
    function rotate_img(id,dir,content){
        var context = $(content);
        var url='http://13loveme.com/alipaies/rotate?id='+id+'&direction='+dir;
        $.ajax({
            url:url,
            dataType:'jsonp',
            processData: false,
            type:'get',
            jsonp: "callbackparam",
            success:function(data){
                $src = 'http://13loveme.com'+data+'?t='+Math.random();
                context.siblings('img').attr('src',$src);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {
                alert(XMLHttpRequest.status);
                alert(XMLHttpRequest.readyState);
                alert(textStatus);
            }});
    }
</script>