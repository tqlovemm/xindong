<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\modules\dating\models\Dating;
use yii\widgets\LinkPager;
$this->title = '往日密约-'.Yii::$app->getRequest()->get('title');
//var_dump(Dating::find()->where(["status"=>2,"title"=>'北京','length(title)'=>7])->all());

$this->registerCss('

            a:hover{text-decoration: none;color:black;}

            .date-today{padding:0 5px;font-size:12px;}
            .date-today .row{margin:0;}
            .date-today spant{color:#636363;}
            .date-today .col-md-6{background-color:#fff;padding:10px;margin-bottom:10px;border:1px solid #EDEDF1;box-shadow: 0 0 0 1px #ededee;border-radius:4px;}

            .date-number span{font-size:14px;}
            .date-mark,.date-friend {line-height:26px;}
            .date-mark span,.date-friend span{padding:1px 3px;color:white;border-radius:3px;white-space:nowrap;}
            .date-mark span{background-color:#ef4450;}
            .date-friend span{background-color:#3e4b8d;}

            .row1-n1{width:99%;background-color: white;box-shadow: 0 0 5px #dbdbdb;padding:20px;height: inherit;margin-bottom: 10px;}

            .sort-main1{border:1px solid red;margin:0 10px;float:left;width:150px;color: rgba(239, 68, 80, 1);background:white;}
            .row1-n1:after{content:".";height:0;clear:both;visibility:hidden;display:block;}

            @media (min-width:768px){

                .date-today{font-size:14px;}

                .date-today .col-md-6{width:49%;margin-right:1%;}

            }

            @media (max-width:768px){

                .date-today{padding:10px 5px;}

                .date-number,.date-mark,.date-friend {line-height:28px;}

                .row1-n1{width:100%;padding:10px 0;}
                .row1-n1 a{float:left;line-height:40px;}

                .sort-main1{width:28%;margin:10px;}
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
        <div class="col-md-10 date-today">
            <div class="row1-n1">
               <a class="btn" href="/wei-web/date-today">
                    <i class=" glyphicon glyphicon-certificate"></i>&nbsp;今日觅约</a>
                <a class="btn" style="<?php if(Yii::$app->request->getPathInfo()=='date-past'){echo 'color:rgba(239, 68, 80, 1);';}?>"  href="http://13loveme.com:8888/wei-web/red">
                    <i class="glyphicon glyphicon-time"></i>&nbsp;往日觅约</a>
                <?= Html::activeDropDownList($mod, 'title', ArrayHelper::map(Dating::findAll(["status"=>2]), 'title', 'title'),['class' => 'sort-main1 form-control'])?>
            </div>
            <script>
                $(function(){
                    $("#dating-title").val('<?=Yii::$app->getRequest()->get('title')?>').attr('disable',true);
                    $('#dating-title').change(
                        function(){
                            var $title = jQuery("#dating-title option:selected").val();
                            window.location.href = '/wei-web/date-past?title='+$title+'&company=13pt';
                        });
                    })
            </script>
            <div class="row" style="min-height: 500px;">
                <?php foreach ($model as $item):
                    $marks = explode('，',$item['content']);
                    $friends = explode('，',$item['url']); ?>
                    <div class="col-md-6 col-sm-6">
                        <a href="<?=Url::to(["wei-web/date-view?id=$item[id]"])?>">
                            <div class="row" style="margin: 0">
                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10" style="padding: 0;">
                                    <div class="date-number">
                                        <spant>妹子编号</spant>
                                        <span><?=$item['number']?></span>
                                    </div>
                                    <div class="date-mark">
                                        <spant>妹子标签</spant>
                                        <?php foreach($marks as $num=>$mark):?>
                                            <?php if($num==3){break;}?>
                                            <span><?=$mark?></span>
                                        <?php endforeach;?>
                                    </div>
                                    <div class="date-friend">
                                        <spant>交友要求</spant>
                                        <?php foreach($friends as $num=>$friend):?>
                                            <?php if($num==4){break;}?>
                                            <span><?=$friend?></span>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-3 col-md-2 col-lg-2" style="padding: 0;">
                                    <img class="img-responsive center-block" alt="<?=$item['url']?>" title="<?=$item['content']?>" src="<?=$item['avatar']?>">
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach;?>
            </div>
            <div class="row text-center">
                <?= LinkPager::widget(['pagination' => $pages]); ?>
            </div>
        </div>
    </div>
</div>