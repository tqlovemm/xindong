<?php
use yii\widgets\LinkPager;
$this->title = Yii::$app->request->get('area');
$this->registerCssFile("@web/css/note/base.css");
$this->registerCssFile("@web/css/note/style.css");
$this->registerCss("
    .navbar,footer,.weibo-share{display:none;}
    .wall-column{width:100%;}
    .count{background-color: #EFB810;color:#fff;top:5px;right:-10px;position: absolute;}
    .article{margin-bottom:10px;}
    .list-header{position: relative;margin: 0;position: fixed;z-index: 999;width: 100%;}
    .list-header a{position: absolute;top:0;color:#EFB810;font-size: 16px;padding:20px 10px 0;}
    .list-header h4{background-color: #1C1B21;padding:20px;margin-top: 0;color: #EFB810;font-weight: bold;}
    .addcar-box{border-top: 1px solid #ddd;padding:10px 10px 0;font-size: 20px;color: #EFB810;}
    .addcar{width: 50%;border: 1px solid #EFB810;margin: 0 auto;border-radius: 50px;padding: 4px;}
    .addcar:hover{color:red;border: 1px solid red;}
");
$qiniu = Yii::$app->params['qiniushiqi'];

?>
<script src="http://13loveme.com/js/jweixin-1.0.0.js"></script>
<div class="row list-header">
    <h4 class="text-center"><?=$this->title?></h4>
    <a href="private-address" style="left:15px;">地区</a>
    <a href="list-detail?flag=<?=$flag?>" style="right:15px;">
        心动<span class="badge count"><?=$count?></span>
    </a>
</div>
<div class="row" style="margin: 0;padding-top:70px;">
    <ul class="wall">
        <?php foreach ($query as $item):?>
        <li class="article">
            <a style="background-color: #fff;position: relative;display: block;" href="seventeen-single?id=<?=$item['id']?>">
                <?php
                $query = (new \yii\db\Query())->from('pre_collecting_17_files_img')->where(['text_id'=>$item['id'],'type'=>2])->one();
                if(!empty($query)){
                    $img = $query['img'];
                }else{
                    foreach ($item['imgs'] as $img){
                        $extend = explode('.',$img['img']);
                        $img = $img['img'];
                        if(in_array($extend[count($extend)-1],['jpg','png','jpeg','bmp','JPG','PNG','JPEG','BMP'])){
                            break;
                        }
                    }
                } ?>
                <img class="img-responsive" src="<?=$qiniu.$img?>" />
                <h5>编号：<?=$item['id']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;区域：<?=$item['address_city']?><span style="color:red;font-weight: bold;float: right;">点击看详情</span></h5>
                <h5><?=$item['age']?> 岁 &nbsp;&nbsp;&nbsp;<?=$item['height']?>cm &nbsp;&nbsp;&nbsp;<?=$item['weight']?>kg</h5>
                <div style="position: absolute;width: 100%;height: 100%;top:0;"></div>
            </a>
            <div class="addcar-box">
                <div class="text-center addcar" data-id='<?=$item['id']?>'>
                   心动 <span class="glyphicon glyphicon-heart" style="vertical-align: middle;"></span>
                </div>
            </div>
        </li>
        <?php endforeach;?>
    </ul>
    <div class="text-center"><?= LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>3]); ?></div>

</div>
<?php
$this->registerJs("

        /*瀑布流*/
        $('.wall').jaliswall({ item: '.article' });
        
        /*ajax增加后宫*/
        $('.addcar',this).on('click',function () {
            var url = 'ajax-add-seventeen?id='+$(this).attr('data-id');
            $.get(url,function (data) {
                $('.count').html(data);
            })
        })
       
    ");
?>
<script>
    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: '<?php echo $signPackage["timestamp"];?>',
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: ['onMenuShareAppMessage'
            // 所有要调用的 API 都要加到这个列表中
        ]
    });

    wx.ready(function () {
        // 在这里调用 API

        wx.onMenuShareAppMessage({
            title: '高端会员交友', // 分享标题
            desc: '请分享给客服，客服会帮你联系她的哦，记住一定要分享给客服哦', // 分享描述
            link: 'http://13loveme.com/bgadmin/seventeen-man/share-list', // 分享链接
            imgUrl: 'http://13loveme.com', // 分享图标
            type: 'link', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
                window.location.href='remove-cookie';
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数条

                alert('取消分享,客服将不知道您想要谁哦');

            }
        });

    });
</script>