<?php
use shiyang\masonry\Masonry;
?>
<div class="row">
    <?php Masonry::begin([
        'options' => [
            'id' => 'photos'
        ],
        'pagination' => $pages
    ]); ?>
    <?php foreach ($model as $item):?>
    <div class="col-md-2" style="padding: 10px;">
        <a style="background-color: #fff;padding: 10px;display: block;color:#000;position: relative;">
            <img class="img-responsive" src="<?='/'.$item['payment_img']?>">
            <h5>上传人：<?=$item['created_by']?></h5>
            <?php if(!empty($item['extra'])):?>
            <h5>备注：<?=$item['extra']?></h5>
            <?php endif;?>
            <time><?=date('Y-m-d H:i:s',$item['created_at'])?></time>
            <a class="delete" data-confirm="确定删除付款截图吗？" style="position: absolute;right: 10px;top: 0;font-size: 20px;color: red;" href="delete-payment?id=<?=$item['id']?>">&times;</a>
        </a>
    </div>
    <?php endforeach;?>
    <?php Masonry::end();?>
</div>
