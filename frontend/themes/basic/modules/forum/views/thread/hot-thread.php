<?php
    use yii\myhelper\Helper;
?>


    <?php
    if(!empty($hotThread)):
        foreach($hotThread as $hot):?>
        <div class="row">
            <div class="col-md-4">
                <img class="img-responsive" src="<?=$hot['avatar']?>">
            </div>
            <div class="col-md-8">
                <div style="min-height: 50px;">
                    <?=Helper::truncate_utf8_string($hot['content'],35)?>
                    <?php if(empty(Helper::truncate_utf8_string($hot['content'],35))):?>
                        <span>纯图片贴</span>
                    <?php endif;?>
                </div>
                <div class="clearfix"></div>
                <div class="pull-left">
                    <i class="glyphicon glyphicon-comment"></i><span><?=$hot['post_count']?></span>
                </div>
                <div class="pull-right">
                    来自：<span class="text-danger"><?=Helper::truncate_utf8_string($hot['username'],5)?></span>
                </div>
            </div>
        </div>
        <br>
        <br>
    <?php
        endforeach;
    else: ?>

        <div class="alert-danger alert">暂无数据！！</div>
    <?php endif;?>