<?php

use yii\helpers\Html;
use yii\helpers\Url;
use shiyang\masonry\Masonry;

$this->title = $model->area;

$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
$this->registerJsFile('@web/js/lightbox/js/lightbox.min.js');
$pre_url = Yii::$app->params['imagetqlmm'];
?>

<div class="flop-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('<i class="glyphicon glyphicon-edit"></i> ' . Yii::t('app', 'Edit Seeks'), ['/flop/flop/update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    <?php if ($model->photoCount == 0 && $model->created_by === Yii::$app->user->id): ?>
        <div class="no-photo">
            <img src="<?= Yii::getAlias('@web/images/no_photo.png') ?>" class="no-picture" alt="No photos">
            <div class="no-photo-msg">                       
                <div><?= Yii::t('app', 'No photo in this seek, click "Upload new photo" to make up your seek.') ?></div>
                <div class="button">
                    <div class="bigbutton">
                        <a href="<?= Url::toRoute(['/flop/flop/upload', 'id' => $model->id]) ?>" class="btn btn-default">
                            <span class="glyphicon glyphicon-plus"></span> <?= Yii::t('app', 'Upload a new photo') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <a href="<?= Url::toRoute(['/flop/flop/upload', 'id' => $model->id]) ?>" class="btn btn-default">
            <span class="glyphicon glyphicon-plus"></span> <?= Yii::t('app', 'Upload a new photo') ?>
        </a>
     <!--   <a href="<?/*= Url::toRoute(['/flop/flop/down', 'url' => Yii::$app->request->getHostInfo().Yii::$app->request->url]) */?>" class="btn btn-default">
            <span class="glyphicon glyphicon-plus"></span> 下载本地区图片
        </a>-->
        <div class="img-all row clearfix">
            <?php Masonry::begin([
                'options' => [
                  'id' => 'photos'
                ],
                'pagination' => $model->photos['pages']
            ]); ?>
            <?php foreach ($model->photos['photos'] as $photo): ?>
                <div class="img-item col-md-3" id="<?= $photo['id'] ?>">
                    <div class="img-wrap" style="position: relative;">
                        <a HREF="<?=Url::toRoute(['/flop/flop-content-search/view','id'=> $photo['id']])?>">
                        <?php if($photo['is_cover']==0):?>
                            <span style="color:white;background-color: rgba(255, 0, 0, 0.58);position: absolute;z-index: 9999;width: 50px;height: 50px;border-radius:50%;line-height: 50px;text-align: center;right: 0px;top:0px;">隐藏</span>
                        <?php endif;?>
                        <img class="img-thumbnail center-block" style="width: 100%;" src="<?=$pre_url.$photo['content'] ?>">
                        </a>
                        <div class="photo-setting" style="padding:0 5%;">
                            <a class="edit-flop-content pull-left" data-id="<?=$photo['id']?>" data-toggle="modal" data-target="#myModal">编辑</a>
<!--                           /*= Html::a('编辑', ['/flop/flop-content-search/update', 'id' => $photo['id']], ['class' => 'pull-left']) */-->
                            <?= Html::a('删除', ['/flop/flop-content-search/delete', 'id' => $photo['id']], [
                                'class' => 'pull-right text-red',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>


            <?php endforeach ?>
            <?php Masonry::end(); ?>
        </div>
    <?php endif ?>
</div>
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row" style="padding:20px;">
                <div class="pull-left col-md-6"><img class="img-responsive" id="flop-avatar" src=""></div>
                <div class="pull-right col-md-6 modal-body">
                    <form name="flop-data">
                        ID：<input id="flop-id" class="form-control" type="text" disabled>
                        地区编号：<input id="flop-area__number" class="form-control" type="text">
                        编号：<input id="flop-number" class="form-control" type="text">
                        身高：<input id="flop-height" class="form-control" type="text">
                        体重：<input id="flop-weight" class="form-control" type="text">
                        描述：<input id="flop-description" class="form-control" type="text">
                        发布：<select id="flop-publish" class="form-control">
                            <option value="1">是</option>
                            <option value="0">否</option>
                        </select>
                        好评：<select id="flop-good_comment" class="form-control">
                            <option value="1">是</option>
                            <option value="0">否</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" id="update-flop-content" class="btn btn-primary" data-dismiss="modal">提交更改</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<?php
    $script = <<<JS

    $('.edit-flop-content',this).click(function(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function stateChanged()
    {
        if (xhr.readyState==4 || xhr.readyState=="complete")
        {

              var data = eval('('+xhr.responseText+')');
              $('#flop-avatar').attr('src',data.path);
              $('#flop-id').val(data.id);
              $('#flop-area__number').val(data.flop_id);
              $('#flop-number').val(data.number);
              $('#flop-height').val(data.height);
              $('#flop-weight').val(data.weight);
              $('#flop-description').val(data.content);
              $('#flop-publish').val(data.is_cover);
              $('#flop-good_comment').val(data.other);

        }
    };
    xhr.open('get','/flop/flop/updated?id='+$(this).attr('data-id'));
    xhr.send(null);

    });

    $('#update-flop-content').click(function(){

    	$.ajax({
		    type: "POST",
			url: "/flop/flop/save?id="+$('#flop-id').val(),
			data: {
			    flop_id:$("#flop-area__number").val(),
				number: $("#flop-number").val(),
				height: $("#flop-height").val(),
				weight: $("#flop-weight").val(),
				content: $("#flop-description").val(),
				is_cover: $("#flop-publish").val(),
				other: $("#flop-good_comment").val(),
			},
			dataType: "json",
			success: function(data){
			  alert(data);
			  return;
				if (data.success) {

                    alert(data.msg);
					$("#createResult").html(data.msg);
				} else {
				          alert(data.msg);
					$("#createResult").html("出现错误：" + data.msg);
				}
			},
			error: function(jqXHR){
			   alert("发生错误：" + jqXHR.status);
			},
		});



    });


JS;

$this->registerJs($script);


?>

