<?php
$dinyue_userinfo = new \frontend\models\DinyueWeichatUserinfo();
$this->title = "#炫腹季#详情";
$session = Yii::$app->session;
if($session->isActive)
    $session->open();

$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
$this->registerJsFile('@web/js/lightbox/js/lightbox.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);
$this->registerCss("

    .container-fluid{padding:0;}
    
    .lightbox .lb-image{z-index:9999;width:250px !important;height:250px !important;}
    .lb-data .lb-number{display:none !important;}
    .lb-data .lb-caption{font-size:16px;}
    .lb-data .lb-close{display:none;}
    .lb-dataContainer{text-align:center;}
    .lb-data .lb-details{margin-top:5px;text-align:right;}
    .lb-nav{z-index:-1;}
    
    .weicaht-note {

    padding: 5px 10px;
    border-radius: 4px;
    font-size: 14px;
    z-index: 100;
    background-color: rgb(231,0,108);
    border: none;
    color: #fff;
    box-shadow: 0 0 7px #d7d7d7;
}
   
");

?>
<div style="background-color: rgb(231,0,108);width: 100%;height: 4em;">
    <a href="note-index">
        <img src="/images/weixin/return.png" style="width: 2.2em;height: 2em;position: absolute;margin-top: 1em;margin-left: 0.5em;"></a>
    <h2 style="color: white;text-align: center;line-height: 56px;margin-top: 0;font-size: 20px;">
        <?=$this->title?>
    </h2>
</div>
<div class="row" style="margin: 0;">
    <img class="img-responsive" src="/images/weixin/banner.jpg">
</div>
<div class="row" style="padding:10px;background-color: #fff;margin:10px 0;border-radius: 5px;">

    <h4>选手编号：<?=$entrants['name']?></h4>
    <?php if($entrants['thumb']!='no'):?>
        <h5>参赛宣言：<?=$entrants['thumb']?></h5>
    <?php endif;?>

    <?php if(isset($to)):?>
        <h5 style="color:rgb(231,0,108);">距离前一名还差：<?=$to?>票</h5>
    <?php endif;?>


</div>
<div class="row" style="padding:10px;background-color: #fff;margin:10px 0;border-radius: 5px;">
    <div class="col-xs-6 note-count" style="padding:0;color:rgb(231,0,108);">
        总票数：<?=$entrants['note_count']?>
    </div>
    <?php if(empty($dinyue_userinfo::findOne(['unionid'=>$session->get('13_openid')]))):?>
        <a class="col-xs-6" style="padding:0;text-align: right;" data-lightbox="d" data-title="请关注微信订阅号进行投票" href="/images/weixin/149129585220305657.jpg">
            <span class="weicaht-note">给TA投票</span>
        </a>
    <?php else:?>
        <div class="col-xs-6" style="padding:0;text-align: right;" onclick="notes(<?=$entrants['id']?>,this)">
            <span class="weicaht-note">给TA投票</span>
        </div>
    <?php endif;?>
</div>
<div class="row" style="padding:0 5px 5px;margin: 0;">
    <?php foreach ($entrants_detail as $item):?>
    <div class="col-xs-12" style="margin-bottom: 10px;padding:0">
        <img class="img-responsive" src="<?=$item['path']?>">
    </div>
    <?php endforeach;?>

</div>
<script>

    function notes(id,context){

        var cons = $(context);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function stateChanged()
        {
            if (xhr.readyState==4 || xhr.readyState=="complete")
            {
                cons.siblings('.note-count').html(xhr.responseText);

            }
        };
        xhr.open('get','/weichat-note/note-click?id='+id);
        xhr.send(null);
    }
</script>