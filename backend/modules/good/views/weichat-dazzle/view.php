<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\WeichatDazzle */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Weichat Dazzles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weichat-dazzle-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('上传图片', ['upload', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'sex',
            'enounce',
            'openId',
            'plateId',
            'num',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
<div class="row">
    <?php foreach($photos as $photo):?>
    <span class="col-xs-3">
        <img class="img-responsive" src="<?=$photo['thumb']?>">
        <a class="btn btn-primary" onclick="rotate_img(<?=$photo['id']?>,1,this)">顺时针</a>
        <a class="btn btn-primary" onclick="rotate_img(<?=$photo['id']?>,2,this)">逆时针</a>
        <?=Html::a('删除',['delete-img','id'=>$photo['id']],[
            'class'=>'btn btn-danger',
            'data'  =>  [
                'confirm'   =>  '确定要删除吗?',
                'method'    =>  'post',
            ]
        ])?>
    </span>
    <?php endforeach;?>
</div>
<script>
    function rotate_img(id,type,content){
        var con = $(content);
        var url = 'http://13loveme.com/alipaies/rotate-abd-img?id='+id+'&direction='+type;
        $.ajax({
            url:url,
            dataType:'jsonp',
            processData:false,
            type:'get',
            jsonp:'callbackparam',
            success:function(data){
                var src;
                var img = data.split('/disk\/shisan\/backend\/web');

                if(img.length<2){
                    img = data.split('/disk\/shisan\/frontend\/web');
                    src = 'http://13loveme.com'+img[1]+'?t='+Math.random();
                }else{
                    src = 'http://13loveme.com:82'+img[1]+'?t='+Math.random();
                }
                con.siblings('img').attr('src',src);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {
                alert(XMLHttpRequest.status);
                alert(XMLHttpRequest.readyState);
                alert(textStatus);
        }});
    }
</script>
