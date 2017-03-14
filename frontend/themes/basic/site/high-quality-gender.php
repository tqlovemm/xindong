<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use \yii\myhelper\AccessToken;
$this->title = '心动后援';
$pre_url = Yii::$app->params['threadimg'];
$this->registerCss('
        a:hover{text-decoration: none;color:black;}

        .date-today{padding:0 5px;font-size:12px;}
        .date-today .row{margin:0;}
        .date-today spant{color:#636363;}
        .date-today .col-md-6{background-color:#fff;padding:10px 10px 0;margin-bottom:10px;border:1px solid #EDEDF1;box-shadow: 0 0 0 1px #ededee;border-radius:4px;}

        .date-number span{font-size:14px;}
        .date-mark,.date-friend {line-height:26px;}
        .date-mark span,.date-friend span{padding:1px 3px;color:white;border-radius:3px;white-space:nowrap;}
        .date-mark span{background-color:#ef4450;}
        .date-friend span{background-color:#3e4b8d;}
        .img-main a{height:200px;width: 100%;display: block;}
        .row1-n1{background-color: white;box-shadow: 0 0 5px #dbdbdb;padding:20px;height: inherit;margin-bottom: 5px;}
        .dating__signup{cursor: pointer;}
        @media (min-width:768px){
            .date-today{font-size:14px;}
            .date-today .col-md-6{width:49%;margin-right:1%;}
        }

        @media (max-width:768px){
            #weibo__show{display:none;}
         .img-main a{height:300px;}
            .date-today{padding:10px 5px;}
            .date-number,.date-mark,.date-friend {line-height:28px;}
            .row1-n1{width:100%;padding:10px 10px;}
            #weibo__guanzhu{display:none;}
        }
');

if(isset($_GET['top'])&&$_GET['top']=='bottoms'){
    $this->registerCss('
        nav,footer,.suo-xia{display:none;}
    ');
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-3 suo-xia">
            <?= $this->render('../layouts/dating_left')?>
        </div>
        <div class="col-md-9 date-today">
            <div class="row1-n1">
                <a href="/date-quality?url=<?=AccessToken::antiBlocking()?>" class="btn btn-default <?php if(Yii::$app->getRequest()->get('type')=='1'||Yii::$app->getRequest()->get('type')==''){echo 'btn-self';}?>">优质男生</a>
                <a href="/date-quality?type=5&url=<?=AccessToken::antiBlocking()?>" class="btn btn-default <?php if(Yii::$app->getRequest()->get('type')=='5'){echo 'btn-self';}?>">优质女生</a>
                <a href="/date-quality?type=2&url=<?=AccessToken::antiBlocking()?>" class="btn btn-default <?php if(Yii::$app->getRequest()->get('type')=='2'){echo 'btn-self';}?>">心动后援</a>
            </div>
            <div class="row" style="min-height: 500px;background-color: #fff;padding:5px 0;">
                <?php foreach($model as $key=>$val):?>
                    <div class="img-item box col-md-3" style="margin-bottom: 10px;padding:5px;">
                        <div class="img-wrap">
                            <div class="img-main">
                                <a href="<?=$pre_url.$val['pic_path']?>" style="background: url('<?=$pre_url.$val['pic_path']?>') no-repeat;background-size:100% auto;" data-lightbox="image-1" data-title="<?= Html::encode($val['name'])?>"></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
            <div class="row text-center">
                <?= LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>0]); ?>
            </div>
        </div>
    </div>
    <?=$this->render('/layouts/bottom')?>
</div>



