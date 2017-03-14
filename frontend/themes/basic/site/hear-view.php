<?php
 use yii\helpers\HtmlPurifier;
use yii\helpers\Html;

    $this->registerCss('

        .hear-img{margin: 10px;}
        .hear-list .row{margin: 0 -10px;}
        ol li{margin-bottom:15px;}
        .comment{display: inline-block;background-color: #DDD;padding:10px;width:100%;}
        .write-comment{margin: 0;padding:5px 15px;}
        .write-comment,
        .write-comment a{color:#ff1a10;}
      .gotop {
            background-image: url(../../../images/iconfont-fanhuidingbu.png);
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 40px;
            height: 40px;
            width: 40px;
            position: fixed;
            right: 10px;
            bottom: 50px;
            z-index: 9999;
            cursor: pointer;
        }
        .hear-row{ }
        @media (max-width:768px){



        }
    ');
if(isset($_GET['top'])&&$_GET['top']=='bottoms'){

    $this->registerCss('
        nav,footer,#comment,.suo-xia{display:none;}
    ');
}
$pre_url = Yii::$app->params['threadimg'];
?>




<div class="container hear-list">
    <div class="row">
        <div class="col-md-3 suo-xia">
            <?= $this->render('../layouts/dating_left')?>
        </div>
        <div class="col-md-9" style="padding: 0;">
            <?php foreach($photos['photos'] as $photo):?>
                <div class="hear-img">
                    <img class="img-responsive center-block" src="<?=$pre_url.$photo['path']?>">
                </div>
            <?php endforeach;?>
        </div>
    </div>

    <div class="row hidden text-center" style="position: fixed;left:5%;background-color: white;padding:10px 20px;">
        <h3>十三平台心动故事</h3>
        <h4>喜欢的话可以在页面底部留言哦</h4>
    </div>
    <div class="row">
        <a href="/contact" class="center-block" style="width: 200px;padding: 10px 20px;font-size: 18px;text-align: center;color:#E83F78;border: 1px solid #E83F78;border-radius: 50px;">尚未入会的点这里</a>
    </div>
    <div id="comment">
    <div class="row write-comment">
        <span class="pull-right">
            <a href="<?=\yii\helpers\Url::to(['/weekly-comment/create','id'=>$weekly_id,'type'=>1])?>">写留言</a>
            <i class="glyphicon glyphicon-pencil"></i>
        </span>
    </div>

    <hr style="border-top: 1px solid #98b7a8;">

    <h5 class="text-center hidden">游客留言区</h5>

    <div class="row" style="min-height: 100px;">
        <?php foreach($comments as $comment):?>
            <div class="comment">
                <div class="col-xs-10" style="padding: 0;">游客：<?=HtmlPurifier::process(Html::encode($comment['content']))?></div>
                <div class="col-xs-2" style="padding-right:0;">
                    <div class="comment-likes" onclick="return notes(<?=$comment['id']?>,this)">
                        <span class="glyphicon glyphicon-thumbs-up"></span>
                        <span style="margin-left: 5px;" class="comment-count"><?=$comment['likes']?></span>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>
</div>
<script>
    function notes(id,con){
        var cons = $(con);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function stateChanged()
        {
            if (xhr.readyState==4 || xhr.readyState=="complete")
            {
                cons.children('.comment-count').html(xhr.responseText);
            }
        };
        xhr.open('get','/index.php/site/note?id='+id);
        xhr.send(null);
    }

</script>