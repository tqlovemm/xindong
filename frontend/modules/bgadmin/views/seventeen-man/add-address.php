<?php
$this->title = '开通新地区';

$this->registerCss("
    .navbar,footer,.weibo-share{display:none;}
    .weui_check_label p{margin:0;}
    .weui_cell_primary h5{margin:0 5px;}
    label{margin-bottom:0;}
    #share{width: 60%;padding:0px;border-radius: 50px;border: 2px solid #F3BA0A;color:#F3BA0A;font-size:20px;background-color: transparent;margin-bottom: 5px;}
    
");
?>
<script src="http://13loveme.com/js/jweixin-1.0.0.js"></script>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<div class="container-fluid" style="padding-bottom: 50px;">
    <div class="row">
        <div class="weui_cells weui_cells_checkbox" style="margin-top: 0;">
            <?php foreach ($area_data as $key=>$list):
            if(in_array($list,$already_areas)):
            ?>
            <label class="weui_cell weui_check_label">
                <div class="weui_cell_hd">
                    <input type="checkbox" class="weui_check" name="checkbox1" disabled>
                    <i class="weui_icon_checked"></i>
                </div>
                <div class="weui_cell_bd weui_cell_primary">
                    <h5 style="color:gray;"><?=$list?>(已开通)</h5>
                </div>
            </label>

              <?php else:?>
                    <label class="weui_cell weui_check_label" data-area=<?=$list?> for="<?=$key?>">
                        <div class="weui_cell_hd">
                            <input type="checkbox" class="weui_check" value="<?=$list?>" id="<?=$key?>">
                            <i class="weui_icon_checked"></i>
                        </div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <h5 style="color:#000;"><?=$list?></h5>
                        </div>
                    </label>
        <?php endif;
        endforeach;?>
        </div>
    </div>
    <div class="text-center row" style="background-color: rgba(0, 0, 0, 0.6);position: fixed;bottom:0;width: 100%;padding-top: 5px;">
        <button id="share" onclick="jqchk()">点我开通 <span class="glyphicon glyphicon-share-alt"></span></button>
    </div>
</div>

<script>

    function jqchk() {

        var chk_value = [];
        var chk_key = [];
        var len=$("input[type='checkbox']:checked").length;

        $("input[type='checkbox']:checked").each(function () {
            chk_value.push($(this).val());
            chk_key.push($(this).attr('id'));
        });

        if(chk_key==0){

            alert('您未选择任何地区');
            return false;
        }

        if(confirm('确定支付开通“'+chk_value+'”'+len+'个地区吗?需支付'+len*500+'元')){

            location.href = 'add-address-wxpay?area='+chk_key;
        }
    }

    /*
     * 注意：
     * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
     * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
     * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
     *
     * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
     * 邮箱地址：weixin-open@qq.com
     * 邮件主题：【微信JS-SDK反馈】具体问题
     * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
     */

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