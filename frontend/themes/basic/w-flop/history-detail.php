<?php
if(empty($openid)){
    $openid = Yii::$app->request->get('openid');
}
$this->title = "翻牌记录";
$this->registerCss("
    .navbar,footer,.weibo-share{display:none;}
    .history-box{background-color: #fff;padding:15px 10px;width: 100%;margin: 0 0 10px;color:#afafaf;font-size: 14px;}
    .history-box-comments{padding:5px 10px;background-color:#E63F78;border-radius: 5px;color:#fff;}
    .comments_content{min-height: 50px;border: 1px solid #ddd;padding:10px;position: relative;}
    .comments_add_content{min-height: 50px;border: 1px dotted #ddd;text-align: center;font-size:16px;line-height:50px;}
    .comments_content_title{position: absolute;left: 10px;top:-10px;color:#E63F78;font-size: 12px;background-color: #fff;}
");

?>
<?php foreach ($model as $item):

    if($item['comments_dated']==0){
        $dated = '约会待定';
    }elseif($item['comments_dated']==1){
        $dated = '已约';
    }else{
        $dated = '未约';
    }

    if($item['comments_evaluate']==0){
        $evaluate = '未评';
    }elseif($item['comments_evaluate']==1){
        $evaluate = '好评';
    }elseif($item['comments_evaluate']==2){
        $evaluate = '一般';
    }else{
        $evaluate = '差评';
    }
?>

    <div class="row history-box">
        <div class="col-xs-5" style="padding: 0;">
            <a href="<?=$item['img']?>" data-lightbox="0" data-title="0">
                <img class="img-responsive" src="<?=$item['img']?>">
            </a>

            <div class="evaluate" style="margin: 15px 0;">
                <span class="history-box-comments"><?=$evaluate?></span>&nbsp;&nbsp;&nbsp;<span class="history-box-comments"><?=$dated?></span>
            </div>
        </div>
        <div class="col-xs-7" style="padding-right: 0;">
            <?php if($item['is_evaluate']==1&&$item['comments_content']==null):?>
                <div class="comments__content">
                    <div class="comments_add_content" data-id="<?=$item['id']?>" data-type="1301" data-toggle="modal" data-target="#commentsModal">
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;点击进行评价
                    </div>
                </div>
            <?php elseif ($item['is_evaluate']==1&&$item['comments_content']!=null&&$item['comments_add_content']==null):?>
                <div class="comments__content">
                    <div class="comments_content">
                        <span class="comments_content_title">评价:</span>
                        <?=$item['comments_content']?>
                    </div>
                    <hr style="margin: 10px 0;">
                    <div class="comments_add_content" data-id="<?=$item['id']?>" data-type="2412" data-toggle="modal" data-target="#commentsModal">
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;点击追加评价
                    </div>
                </div>
            <?php elseif($item['is_evaluate']==1):?>
                <div class="comments__content">
                    <div class="comments_content">
                        <span class="comments_content_title">评价:</span>
                        <?=$item['comments_content']?>
                    </div>
                    <hr style="margin: 10px 0;">
                    <div class="comments_content">
                        <span class="comments_content_title">追评:</span>
                        <?=$item['comments_add_content']?>
                    </div>
                </div>
            <?php else:?>
                <div class="comments__content">
                    <a href="comments?openid=<?=$openid?>" class="btn btn-default">去评价<span class="glyphicon glyphicon-menu-right"></span></a>
                </div>
            <?php endif;?>

        </div>
    </div>

<?php endforeach;?>
<!-- 模态框（Modal） -->
<div class="modal fade" id="commentsModal" tabindex="-1" role="dialog" aria-labelledby="commentsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="commentsModalLabel">翻牌评价</h4>
            </div>
            <div class="modal-body">
                <form id="add__comments" action="add-comments?openid=<?=$openid?>" method="post">
                    <input id="hidden__id" type="hidden" value="" name="id">
                    <input id="hidden__type" type="hidden" value="" name="type">
                    <textarea class="form-control" name="add-comments" maxlength="30" title="addComments"></textarea>
                    <div class="form-group clearfix" style="margin-top: 15px;">
                        <input class="btn btn-primary pull-right" type="submit" value="提交评价">
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script>
    $(function () {

        $('.comments_add_content',this).on('click',function () {

            $('#hidden__id').attr('value',$(this).attr('data-id'));
            $('#hidden__type').attr('value',$(this).attr('data-type'));

        });

    });

</script>
