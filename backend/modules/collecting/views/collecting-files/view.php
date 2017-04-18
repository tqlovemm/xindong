<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Collecting17FilesText */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Collecting17 Files Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$pre_url = Yii::$app->params['qiniushiqi'];
?>
<div class="collecting17-files-text-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(!in_array(Yii::$app->user->id,[13674])):?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif;?>
    </p>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'address_province',
                'address_city',
                'address_province2',
                'address_city2',
                'address_province3',
                'address_city3',
                'address_detail',
                'education',
                'age',
                'sex',
                'height',
                'weight',
                'cup',
                'already_pa',
                'job',
                'job_detail',
                'extra',
                'weichat',
                'cellphone',
                'weibo',
                'id_number',
                'pay',
                'qq',
                'created_at:date',
                'status',
            ],
        ]) ?>
    <div class="row">
    <?php foreach ($img as $item):?>
        <div class="col-md-2">
            <img class="img-responsive" src="<?=$pre_url.$item['img']?>">
            <a class="btn btn-primary" onclick="rotate_img(<?=$item['id']?>,1,this)">顺时针</a>
            <a class="btn btn-primary" onclick="rotate_img(<?=$item['id']?>,2,this)">逆时针</a>
            <?php if(!in_array(Yii::$app->user->id,[13674])):?>
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
        var url='http://13loveme.com/alipaies/rotate-seventeen?id='+id+'&direction='+dir;
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