<?php

$this->title = '联系我们';
$this->params['breadcrumbs'][] = $this->title;
$pre_url = Yii::$app->params['threadimg'];
$this->registerCss('

        .left{float:left;}
        .right{float:right;}

      @media (max-width: 768px) {
            .left{float:none;}
            .right{float:none;}
        }
');
?>
<?php
$dependency = [
    'class' => 'yii\caching\DbDependency',
    'sql' => 'SELECT MAX(created_at) FROM pre_website_content',
];
if ($this->beginCache($id=29, ['dependency' => $dependency])) :?>
<div class="container visible-lg visible-md" style="padding: 0;">
    <div class="row">
        <div class="col-md-12">
            <div style="background-image: url('<?=Yii::getAlias('@web')?>/images/contact1.jpg');width: 100%;height: 600px;background-position: center;background-size: 100% 100%;background-repeat: no-repeat;padding-top:2em;">
                <div style="width: 20em;height: 10em;background-color: rgba(255, 255, 255, 0.51);padding:0.6em;margin:auto;">
                    <div style="width: 100%;height: 100%;background-color: rgba(0, 0, 0, 0.22);">
                        <div style="color: white;font-size: 55px;text-align: center;">联系我们</div>
                        <div style="color: red;font-size: 30px;text-align: center;font-family:YGY20070701xinde52;">contact us</div>
                    </div>
                </div>
                <div class="center-block" style="width: 90%;height: 13em;background-color: rgba(0, 0, 0, 0.09);padding:0.6em;margin-top: 7em;">
                    <h2 class="text-center" style="color:white;font-weight: bold;">这里就是传说中的交友圣地，如伊甸园的13交友平台，单纯、素质交友！</h2><br>
                    <h2 class="text-center" style="color:white;font-weight: bold;">来这里多吃些果子吧。</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container visible-lg visible-md" style="background-image: url('<?=Yii::getAlias('@web')?>/images/contact2.jpg');
    background-repeat: no-repeat;background-position:center;background-size: cover;padding-top:2em;margin-top: 2px;">
    <div class="row">
        <div class="col-md-3 col-md-offset-1">
            <img class="center-block img-responsive" src="<?=Yii::getAlias('@web')?>/images/contact3.png" width="200" height="220" title="十三平台女生入会" alt="十三平台女生入会">
        </div>
        <div class="col-md-2">
            <div class="center-block" style="width: 180px;height:180px;border-right:1px solid red;
                            border-radius: 50%;margin-top: 2em;padding-top: 2.2em;">
                <h2 class="text-center" style="color:#E76F83;font-weight: bold;">如果你是</h2>
                <h1 class="text-center" style="color:#E76F83;font-weight: bold;">妹子</h1>
            </div>
        </div>
        <div class="col-md-5">
            <img class="img-responsive center-block" src="<?=Yii::getAlias('@web')?>/images/weixin/596829214713487337.jpg" width="200">
            <div class="clearfix"></div>
            <h5 class="text-danger text-center" style="letter-spacing: 1.1em;">只要你有需求，十三平台与你同在</h5>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-3 col-md-offset-1">
            <img class="center-block img-responsive" src="<?=Yii::getAlias('@web')?>/images/contact4.png" width="200" height="220" title="十三平台男生入会" alt="十三平台男生入会">
        </div>
        <div class="col-md-2">
            <div class="center-block" style="width: 180px;height:180px;border-right:1px solid red;
                            border-radius: 50%;margin-top: 2em;padding-top: 2.2em;">
                <h2 class="text-center" style="color:#E76F83;font-weight: bold;">如果你是</h2>
                <h1 class="text-center" style="color:#E76F83;font-weight: bold;">汉子</h1>
            </div>
        </div>
        <div class="col-md-5">
            <img class="img-responsive center-block" src="<?=$pre_url.$boy[0]->path?>"  width="200" style="margin-top: 10px;">
            <div class="clearfix"></div>
            <h5 class="text-success text-center" style="letter-spacing: 1.1em;">只要你有需求，十三平台与你同在</h5>
        </div>
    </div>
</div>

<div class="container visible-xs visible-sm" style="padding: 0;">
    <img class="img-responsive center-block" src="<?=$pre_url.$boy_phone[0]->path?>">
</div>
<?php $this->endCache();endif;?>