<?php
if(empty($openid)){
    $openid = Yii::$app->request->get('openid');
}
use shiyang\masonry\Masonry;
$this->title = "翻牌记录";
$this->registerCss("
    .navbar,footer,.weibo-share{display:none;}
    .history-box{background-color: #fff;padding:15px 10px;width: 100%;margin: 0;color:#afafaf;font-size: 14px;}
");

?>
<script src="http://13loveme.com/js/jweixin-1.0.0.js"></script>

<?php Masonry::begin([
    'options' => [
        'id' => 'photos'
    ],
    'pagination' => $pages
]); ?>

<?php foreach ($model as $key=>$item):
    
    $priorities = explode(',',$item['priority']);
    ?>
    <div class="history-box-footer" style="margin-bottom: 10px;color:#000;" data-flag="<?=$item['flag']?>" data-id="<?=$item['id']?>" data-priority=<?=urlencode($item['priority'])?>>
        <div class="row history-box" style="border-bottom:1px solid #ddd;">
            <div class="col-xs-9" style="padding: 0;">
                <?php foreach ($priorities as $k=>$list):
                    if($k==3) break;
                    $query = (new \yii\db\Query())->select('path')->from('pre_flop_content')->where(['id'=>$list])->one(); ?>
                    <img style="width: 32%;" src="<?=$query['path']?>">
                <?php endforeach;?>
            </div>
            <div class="col-xs-3" style="text-align: right;font-size: 20px;color: #000;line-height: 70px;">
                <span class="glyphicon glyphicon-menu-right"></span>
            </div>
        </div>
        <div class="row history-box" style="color:#000;">
            <div class="col-xs-6" style="padding: 0;"><?=date('Y年m月d日 H:i',$item['created_at'])?></div>
            <div class="col-xs-4" style="border-left: 1px solid #ddd;">共<?=count($priorities)?>人</div>
            <div class="col-xs-2" style="padding: 0;"><span style="background-color:#E63F78;color:#fff;padding:2px 5px;border-radius: 5px;">+追评</span></div>
        </div>
    </div>
<?php endforeach;?>

<?php Masonry::end();?>

<script>
    $(function () {

        $('.history-box-footer',this).on('click',function () {

            window.location.href='history-detail?openid=<?=$openid?>&priority='+$(this).attr('data-priority')+'&flag='+$(this).attr('data-flag');

        });

    });

</script>
