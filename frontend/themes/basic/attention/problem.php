
<?php

$this->title='常见问题';

$this->registerCss('

        .attention>li{line-height:25px;margin:10px 0;}

    ');
?>
<div class="container">

    <div class="row">

        <div class="col-md-2">
            <?= $this->render('./attention-left')?>
        </div>
        <div class="col-md-9">
            <h1 class="text-center"><?=\yii\helpers\Html::encode($this->title)?></h1>
            <ol class="list-group attention">
                <li  class="list-group-item"><h5 class="text-danger"><span>1～</span>那在哪里能看到妹子信息呢？</h5>
                    <p class="text-warning">答：我有整理好的妹子历史信息可供你查看。 我们的官网每天都有大量妹子寻约信息发布。
                    每天的妹子信息更新只有入会后你的会员客服的朋友圈（普通会员为十三爷交友平台，高端及以上会员为私人客服）会发布。
                    入会后有机会加上平台福利君号，每天定时推送妹子信息。</p></li>
                <li class="list-group-item"><h5 class="text-danger"><span>2～</span>平台有多久历史了？男女会员各有多少了呀？</h5>
                    <p class="text-warning">答：十三平台建于13年10月份，已有两年历史。  男女人数总人数已经10000+。</p></li>
                <li class="list-group-item"><h5 class="text-danger"><span>3～</span>我在国外能不能约到妹子？</h5>
                        <p class="text-warning">答：我们的会员遍布全球（包括非洲和南美洲）。海外资源比较多的地区有英法美加澳。</p></li>
                <li class="list-group-item"><h5 class="text-danger"><span>4～</span>平台里的妹子约会的时候还要不要给她钱？</h5>
                    <p class="text-warning">答：平台里的妹子也是跟你们一样从微博！ins等我们的宣传渠道看到或者是朋友介绍加过来的。
                    都是良家妹子（我们不知情的情况除外），平台和妹子、妹子和汉子之间均无金钱交易。</li>
                <li class="list-group-item"><h5 class="text-danger"><span>5～</span>十三爷，我有钱可是没时间跟妹子聊，想约怎么办？</h5>
                    <p class="text-warning">答：首先我们有能提高成功率、简化沟通过程的私人订制服务；其次我们平台有一些来求互助的妹子。具体情况联系我知晓。</p></li>
                <li class="list-group-item"><h5 class="text-danger"><span>6～</span>我第一次用这种平台，可以先试用么？</h5>
                    <p class="text-warning">答：没有试用。平台各个号各司其职，我只负责入会。  我们会给你充分证明我们真实性的资料，妹子推荐按照会员制度进行。</p></li>
                <li class="list-group-item"><h5 class="text-danger"><span>7～</span>普通会员我们制作的档案是放哪里的？翻牌是怎么进行？</h5>

                    <p class="text-warning">答：会员的档案我们放在云盘，首先保证隐私安全。  妹子来寻约的时候我们会把该地区汉子的档案发给她，她挑中了谁我们就会通知汉子并把妹子联系方式给他。</p>
                    </li>

            </ol>

            <h4 class="text-green">新人请仔细阅读，重复问题不再回答。谢谢。</h4>
        </div>
    </div>
</div>