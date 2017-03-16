<?php
use shiyang\masonry\Masonry;
$this->title = "寻约记";
$this->registerCss("

  li{list-style: none;}

");
$pre_url = Yii::$app->params['shisangirl'];
?>
    <link rel="stylesheet" href="<?=Yii::getAlias("@web")?>/js/more/pullToRefresh.css" />
    <script src="<?=Yii::getAlias("@web")?>/js/more/iscroll.js"></script>
    <script src="<?=Yii::getAlias("@web")?>/js/more/pullToRefresh.js"></script>
<div class="row member-center">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?=$this->title?></h2>
        </div>
    </header>
</div>
<div id="wrappers" class="row">
    <ul class="list-group">
        <?php Masonry::begin([
            'options' => [
                'id' => 'photos'
            ],
            'pagination' => $pages
        ]); ?>

        <?php foreach($model as $item):
        $extra = json_decode($item['extra'],true);
        $value = $item['status'];
        switch($value){
            case 9:
            case 10:
                $op="冻结";break;
            default:$op="扣除";
        } ?>
            <li class="enter-dating-detail" data-id="<?=$item['id']?>" style="border-bottom: 1px solid #f3f3f3;background-color: #fff;padding:10px 5px;width: 100%;">
                <div class="col-xs-3" style="padding: 0;">
                    <img class="img-responsive" style="border-radius: 5px;width: 70px;" src="<?=$pre_url.$extra['avatar']?>">
                </div>
                <div class="col-xs-9" style="padding: 0;position: relative;">
                    <h5 style="margin-top: 5px;">
                        <span style="font-weight: bold;"><?=$extra['number']?></span>
                        <span style="margin:0 10px;"><?=$op?><?=$item['number']?>节操币</span>
                        <?php if($item['status']==10||$item['status']==9):?>
                            <span style="color:orange">等待中</span>
                        <?php elseif($item['status']==11):?>
                            <span style="color:green">成功</span>
                        <?php elseif($item['status']==12):?>
                            <span style="color:red">失败</span>
                        <?php endif;?>
                    </h5>
                    <h6><?=$extra['mark']?></h6>
                    <h6 style="margin-bottom: 0;"><?=$extra['require']?></h6>
                </div>
            </li>

        <?php endforeach; ?>
        <?php Masonry::end();?>

    </ul>
</div>

<?php

$this->registerJs("

      $('.enter-dating-detail',this).on('click',function(){

            window.location.href='dating-record-detail?id='+$(this).attr('data-id');

        });

    ");
?>