<div class="row text-center" style="border-bottom: 2px solid orange;">
    <div class="col-md-2">用户id</div>
    <div class="col-md-2">用户编号</div>
    <div class="col-md-1">档案照</div>
    <div class="col-md-3">时间</div>
    <div class="col-md-3">操作</div>
</div>
<?php foreach($avatar_check as $item):

        $number = \frontend\models\UserData::getNumberForId($item['user_id']);
    ?>

<div class="row text-center" style="border-bottom: 2px solid red;padding:10px;">
    <div class="col-md-2"><?=$item['user_id']?></div>
    <div class="col-md-2"><?=$number?></div>
    <div class="col-md-1"><a href="<?=$item['file']?>" data-lightbox="d" data-title="<?=$number?>"><img class="img-responsive" src="<?=$item['file']?>"></a></div>
    <div class="col-md-3"><?=date('Y-m-d H:i:s',$item['updated_at'])?></div>
    <div class="col-md-3">
        <a href="file-check-op?status=10&id=<?=$item['user_id']?>&reason=通过" class="btn btn-success" data-confirm="确认通过吗？">通过</a>
        <a class="btn btn-danger not_passes" data-toggle="modal" data-id="<?=$item['user_id']?>" data-target="#myModal">不通过</a>
    </div>
</div>
<?php endforeach;?>

<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">模态框（Modal）标题</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <form action="file-check-op" method="get">
                        <input class="form-control" type="hidden" name="status" value="0">
                        <input class="form-control" type="hidden" id="check_id" name="id">
                        <input class="form-control" type="text" name="reason" id="no_pass_reason" placeholder="请填写不通过原因" required>
                        <input class="btn btn-primary" type="submit">
                    </form>

                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<?php

    $this->registerJs("
    
        $('.not_passes',this).on('click',function () {
        
            $('#check_id').val($(this).attr('data-id'));
        });

    ");

?>
