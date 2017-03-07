<?php
    use yii\widgets\LinkPager;
$this->registerCss('
    .content-box{padding:5px;background-color:#fff;border-bottom:1px solid #ddd;}
    .content-box .col-md-3{padding:0}

');
?>
    <div class="row">
        <div class="col-md-1">会员ID</div>
        <div class="col-md-1" style="padding: 0;">会员名</div>
        <div class="col-md-1" style="padding: 0;">昵称</div>
        <div class="col-md-1">用户编号</div>
        <div class="col-md-1" style="padding: 0;">注册手机号</div>
        <div class="col-md-1">节操币数量</div>
        <div class="col-md-1">会员等级</div>
        <div class="col-md-2">是否通知</div>
        <div class="col-md-3">通知备注</div>
    </div>

<?php foreach ($model as $item):
        $grade = ($item['groupid']==3)?'高端会员':'至尊会员';
        if($item['userData']['jiecao_coin']<=100){$color = "#E97575";}else{$color = "orange";}
        $notices = (new \yii\db\Query())->from('pre_jiecaobi_notice')->where(['user_id'=>$item['id']])->one();
        if($notices['notice']==0||$notices['notice']==null){
            $notice='未通知';
        }elseif($notices['notice']==1){
            $notice='已通知';
        }else{$notice='其他';}

    ?>
    <div class="row content-box">
        <div class="col-md-1"><?=$item['id']?></div>
        <div class="col-md-1" style="padding: 0;"><?=$item['username']?></div>
        <div class="col-md-1" style="padding: 0;"><?=$item['nickname']?></div>
        <div class="col-md-1"><?=$item['profile']['number']?></div>
        <div class="col-md-1" style="padding: 0;"><?=$item['cellphone']?></div>
        <div class="col-md-1" style="background-color: <?=$color?>"><?=$item['userData']['jiecao_coin']?></div>
        <div class="col-md-1"><?=$grade?></div>
        <div class="col-md-2"><?=$notice?><?php if($notices['notice']!=1):?>&nbsp;&nbsp;<a data-uid="<?=$item['id']?>" data-id="<?=$notices['id']?>" class="btn btn-danger notice__s" data-toggle="modal" data-target="#myModal">通知</a><?php endif;?></div>
        <div class="col-md-3">
            <?=$notices['result']?>
        </div>
    </div>
<?php endforeach;?>

<?= LinkPager::widget(['pagination' => $pages]); ?>

<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">节操比不足通知</h4>
            </div>
            <div class="modal-body">
                <form action="notice" method="post">
                    <input id="hidden-id" type="hidden" value="" name="id">
                    <input id="hidden-uid" type="hidden" value="" name="uid">
                    <textarea name="notice" class="form-control" title=""></textarea>
                    <input class="btn btn-default" type="submit" value="通知备注">
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<?php

    $this->registerJs("
    
        $('.notice__s',this).on('click',function () {

            $('#hidden-id').val($(this).attr('data-id'));
            $('#hidden-uid').val($(this).attr('data-uid'));

        });
    ");
?>
