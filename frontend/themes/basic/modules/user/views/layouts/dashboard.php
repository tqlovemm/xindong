<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\home\models\Sigin;
$userProfile = Yii::$app->userProfile->getKey(true);
$sigin = Yii::$app->sigin->getKey(true);
$user = Yii::$app->user->identity;
$done = Yii::$app->db
    ->createCommand("SELECT 1 FROM {{%user_follow}} WHERE user_id=:user_id AND people_id=:id LIMIT 1")
    ->bindValues([':user_id' => Yii::$app->user->id, ':id' => $this->params['user']['id']])->queryScalar();
if ($done) {
    $followBtn = '<span class="glyphicon glyphicon glyphicon-eye-close"></span> ' . Yii::t('app', 'Unfollow');
} else {
    $followBtn = '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'Follow');
}
$this->registerCss('

    .container,.wrap{padding-top:0 !important;}

    .bg-white{background-color:white;min-height:40px;line-height:40px;}
    .main-hen1,.main-hen2{background:none;border: none;padding:10px 20px;color:black;}

    .padding-md{padding:0 15px !important;}

    @media (min-width: 1200px){
        .container {
            width: 1200px !important;
        }
    }
    @media (max-width: 768px){

         .main-hen1,.main-hen2{margin: auto;float:none;}
    }
');
?>
<?php $this->beginContent('@app/modules/user/views/layouts/user.php'); ?>
<div class="social-wrapper row">
    <div id="social-container">
        <div class="row">
            <div style='width: 100%;height: 250px;background:url("<?=Yii::getAlias('@web')?>/images/home/home_top.gif") 100% #e0ddd6;padding:20px 0;'>

                <div class="text-center" style="padding:10px 20px;">
                    <img style="width: 80px;" class="img-circle img-responsive center-block" src="<?= $this->params['user']['avatar'] ?>">
                    <h2 class="profile-name">

                        <?php if(!empty($this->params['user']['nickname'])){echo Html::a(Html::encode($this->params['user']['nickname']), ['/user/view', 'id' => Html::encode($this->params['user']['username'])]);}else{echo Html::a(Html::encode($this->params['user']['username']), ['/user/view', 'id' => Html::encode($this->params['user']['username'])]);} ?>

                    </h2>
                    <?php if (!empty($this->params['profile']['description'])): ?>
                        <p class="mb30"><?= Html::encode($this->params['profile']['description']) ?></p>
                    <?php endif ?>
                    <div class="mb20"></div>
                    <?php if($this->params['user']['id']==Yii::$app->user->id):?>
                        <h4 style="color: black;"><span class="text-danger text-bold">我的节操币：</span>
                            <span class="text-danger" id="feed_data"><?=$sigin['sigindata']?></span>
                            <span class="glyphicon glyphicon-usd text-danger"></span>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php if(Sigin::getIsSign()):?>
                                <span><a class="btn btn-danger btn-sm disabled">今日已签到</a></span>
                            <?php else:?>
                                <span id="isSign">
                                <a class="btn btn-danger btn-sm" onclick="sigin();">签到打卡</a>
                                </span>
                            <?php endif;?>
                        </h4>
                    <?php else:?>
                        <a class="btn btn-success follow btn-sm" href="<?= Url::toRoute(['/user/user/follow', 'id' => $this->params['user']['id']]) ?>"><?= $followBtn ?></a>
                    <?php endif;?>
                </div>
                <script>
                    function sigin(){
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function stateChanged()
                        {
                            if (xhr.readyState==4 || xhr.readyState=="complete")
                            {
                                document.getElementById("feed_data").innerHTML=xhr.responseText;
                                document.getElementById("isSign").innerHTML = '<a class="btn btn-danger btn-sm disabled">今日已签到</a>';
                            }
                        };
                        xhr.open('get','/index.php/home/feed');
                        xhr.send(null);
                    }

                    $('.follow').on('click', function () {
                        var a = $(this);
                        $.ajax({
                            url: a.attr('href'),
                            success: function (data) {
                                if (data.action == 'create') {
                                    a.html('取消关注');
                                    history.go(0);

                                } else {
                                    a.html('点击关注');
                                    history.go(0);
                                }
                            },
                            error: function (XMLHttpRequest, textStatus) {
                                location.href = "<?= Url::toRoute(['/site/login']) ?>";
                            }
                        });
                        return false;
                    });
                </script>
            </div>
        </div>

            <div class="row text-center bg-white">
                <a class="main-hen1" href="/index.php/u/<?=$this->params['user']['id']?>">个人主页</a>
                <a class="main-hen2" href="/index.php/user/view/album?id=<?=$this->params['user']['id']?>">我的相册</a>
                <a class="main-hen2" href="/index.php/user/view/post?id=<?=$this->params['user']['id']?>">私密日志</a>
            </div>
      <br>

    </div>

        <?= $content ?>
    </div>
</div>
<?php $this->endContent(); ?>
