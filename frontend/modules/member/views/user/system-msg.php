<?php
use shiyang\masonry\Masonry;
$this->title = "系统消息";

$this->registerCss("

    .purchase-history{padding:0 10px;margin-top:10px;}
    .purchase-history-box{background-color:#fff;padding:10px;box-shadow: 0 0 3px #D5D3D3;border-radius:5px;font-size:12px;}
    .bg-warning{padding: 5px;border-top-left-radius: 5px;border-top-right-radius: 5px;}
");


?>
<div class="row member-center">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?=$this->title?></h2>
        </div>
    </header>
</div>

<div class="row">

    <div class="timeline animated">

        <?php Masonry::begin([
            'options' => [
                'id' => 'photos'
            ],
            'pagination' => $pages
        ]); ?>
        <?php foreach($model as $item):

            $msg = $item['content'];

            ?>
            <div class="timeline-row data-<?=$item['id']?>">
                <div class="timeline-icon">
                    <div class="bg-warning">
                        <i class="glyphicon glyphicon-time"></i> <span><?=date("Y-m-d",$item['created_at'])?></span>
                        <?php if(in_array($item['status'],[5,4])):?>
                            <a data-id="<?=$item['id']?>" class="msg-delete glyphicon glyphicon-trash pull-right" style="margin-right: 10px;font-size: 18px;"></a>
                        <?php endif;?>
                    </div>
                </div>
                <div class="panel timeline-content">
                    <div class="panel-body">
                        <h4 style="margin-top: 0;"><?=$item['title']?></h4>
                        <?php if(!empty($item['file'])):?>
                            <img class="img-responsive center-block" src="<?=$item['file']?>" />
                        <?php endif;?>
                        <p><?=$msg?></p>
                    </div>
                </div>
            </div>
        <?php endforeach;?>

        <?php Masonry::end();?>
    </div>
</div>
<?php

$this->registerJs("
        $('.msg-delete',this).on('click',function(){

            if(confirm('确认删除吗？')){

                $.get('system-msg-delete?id='+$(this).attr('data-id'),function(msg){

                    $('.data-'+msg).slideUp(600);

                },'json');
            }

        });

");

?>
