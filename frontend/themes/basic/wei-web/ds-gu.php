
<?php

    $this->title = "你的爱慕者";
    $this->registerCss("

        .dating__signup_info{}
        header{height:44px;background: #E83F78;position: relative;z-index: 10;}
        header a{color:white;position: absolute;}
        header h2{color: #fff;font-size: 16px;font-weight: normal;height:44px;text-align: center;line-height:44px;font-weight: bold;margin-top: 0;}
        header span{display: block;height: 35px;text-indent: 17px;width: 50px;color: #FFF;font-size: 14px;padding-top: 8px;margin-left: -10px;}
        header span img{width: 25px;}

        .water-mark-hide{display:none;}
        .water-mark{padding:10px;color:#fff;font-size:24px;background-color: rgba(255, 0, 0, 0.4);z-index: 9999;position: absolute;top:0;left:0;display:none;}

    ");
    $this->registerCssFile('@web/js/lightbox/css/lightbox.css');
    $this->registerJsFile('@web/js/lightbox/js/lightbox.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);

?>

<div class="dating__signup_info">
    <header class="row">
        <div class="header">
            <a href="#" style="left:3%;top:0;font-size:14px;line-height: 44px;position: absolute;"><i id="signup__number"><?=count($models)?></i>人报名</a>
            <h2><?=$this->title?></h2>
            <a style="right:3%;top:0;font-size:14px;line-height: 44px;position: absolute;">
                教程
            </a>
        </div>
    </header>
    <?php foreach($models as $key=>$model):

        $info = json_decode($model['extra'],true);?>
        <div class="box" data-number="<?=$key?>" data-id="<?=$model['id']?>" data-like="<?=$model['like_id']?>">
            <div class="row" style="padding: 4px 8px;background-color: rgba(60, 190, 164, 0.71);color: #fff;">
                <span class="glyphicon glyphicon-time"></span> <?=date('Y-m-d H:i:s',$model['created_at'])?>
            </div>
            <div class="row" style="background-color: #fff;padding:10px;">
                <a href="<?=$info['image']?>" data-lightbox="image" data-title="">
                    <div style="height: 200px;overflow: hidden;position: relative;">
                         <img class="img-responsive center-block" src="<?=$info['image']?>">

                        <?php if($model['status']==0):?>
                            <span class='water-mark like<?=$key?>'>喜欢</span>
                            <span class='water-mark so-so<?=$key?>'>备胎</span>
                        <?php elseif($model['status']==1):?>
                            <span class='water-mark like<?=$key?>' style="display: block;">喜欢</span>
                            <span class='water-mark so-so<?=$key?>'>备胎</span>
                        <?php elseif($model['status']==2):?>
                            <span class='water-mark like<?=$key?>'>喜欢</span>
                            <span class='water-mark so-so<?=$key?>' style="display: block;">备胎</span>
                        <?php endif;?>
                    </div>
                </a>
            </div>

            <div class="row credit-list text-center" style="border-top: 1px solid #f3f3f3;margin-bottom: 15px;background-color: #fff;">
                <div class="like_click col-xs-4" style="padding:5px;">
                    <span href="#" style="color: #3cbea4;">
                        <span class="glyphicon glyphicon-heart"></span>  喜欢
                    </span>
                </div>
                <div class="so-so_click col-xs-4" style="padding:5px;border-right: 1px solid #f3f3f3;border-left: 1px solid #f3f3f3;">
                    <span href="#" style="color: #3cbea4;">
                        <span class="glyphicon glyphicon-adjust"></span>  备胎
                    </span>
                </div>
                <div class="dislike_click col-xs-4" style="padding:5px;">
                    <span href="#" style="color: #3cbea4;">
                        <span class="glyphicon glyphicon-trash"></span>  没感觉
                    </span>
                </div>
            </div>
        </div>
        <div class="cccc"></div>

    <?php endforeach; ?>
</div>
<?php
    $this->registerJs("

          $('.like_click',this).on('click',function(){

                var number = $(this).parents('.box').attr('data-number');

                if($('.like'+number).css('display')=='none'&&$('.so-so'+number).css('display')=='block'){

                    $('.like'+number).fadeIn(function(){

                        $.get('/wei-web/ajax-operation?status=1&id='+$(this).parents('.box').attr('data-id'));
                    });
                    $('.so-so'+number).hide();

                }else {

                    $('.like'+number).fadeToggle(function(){

                        $.get('/wei-web/ajax-operation?status=1&id='+$(this).parents('.box').attr('data-id'));

                    });
                }

          });

         $('.so-so_click',this).on('click',function(){

            var number = $(this).parents('.box').attr('data-number');

            if($('.so-so'+number).css('display')=='none'&&$('.like'+number).css('display')=='block'){

                $('.like'+number).hide();
                $('.so-so'+number).fadeIn(function(){

                      $.get('/wei-web/ajax-operation?status=2&id='+$(this).parents('.box').attr('data-id'));
                });

            }else {

                $('.so-so'+number).fadeToggle(function(){

                        $.get('/wei-web/ajax-operation?status=2&id='+$(this).parents('.box').attr('data-id'));

                    });
            }

        });
           $('.dislike_click',this).on('click',function(){

            if(confirm('确定删除吗')){
                 $.get('/wei-web/ajax-operation?status=3&id='+$(this).parents('.box').attr('data-id')+'&like_id='+$(this).parents('.box').attr('data-like'),function(result){
                    $('#signup__number').html(result);
                 });
                 $(this).parents('.box').fadeOut('slow');
            }

        });

    ");
?>