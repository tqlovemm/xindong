<?php
use shiyang\masonry\Masonry;
$this->registerCss("
    .navbar,footer,.weibo-share{display:none;}
    .history-box{background-color: #fff;padding:15px 10px;width: 100%;margin: 0;color:#afafaf;font-size: 14px;}
");
?>

<?php Masonry::begin([
    'options' => [
        'id' => 'photos'
    ],
    'pagination' => $pages
]); ?>

<?php foreach ($model as $key=>$item):
    $members = explode(',',$item['member_id']);
    ?>
    <div class="history-box-footer" style="margin-bottom: 10px;color:#000;">
        <div class="row history-box" style="border-bottom:1px solid #ddd;">
            <div class="col-xs-12" style="padding: 0;">
                <?php foreach ($members as $k=>$list):?>
                    <span><?=$list?></span>
                <?php endforeach;?>
            </div>
        </div>
        <div class="row history-box" style="color:#000;">
            <div class="col-xs-12" style="padding: 0;"><?=date('Y年m月d日',$item['created_at'])?></div>
        </div>
    </div>
<?php endforeach;?>

<?php Masonry::end();?>