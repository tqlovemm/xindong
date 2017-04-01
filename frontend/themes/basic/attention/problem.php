
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
                <li  class="list-group-item"><h5 class="text-danger"><span>1～</span>平台有多久历史了？</h5>
                    <p class="text-warning">答：十三平台创建于13年10月份，至今已有3年半历史，男女会员总数50000+。</p></li>
                <li class="list-group-item"><h5 class="text-danger"><span>2～</span>朋友圈报名、网站报名是什么意思？会员是什么？有什么用？</h5>
                    <p class="text-warning">答：朋友圈报名和网站报名这个是针对会员的权限，朋友圈报名就是我们发布在朋友圈并说明接受报名的女生你可以在朋友圈直接报名，网站报名就是网站“最新觅约”和“十三救我”里面发布的女生可以在网站上操作报名；
                        会员的话，因为我们平台是会员制的，如果不是平台会员就享受不到平台上相应的福利哦；
                        会员的用处嘛，无非是勾搭妹子，心照不宣啦。</p></li>
                <li class="list-group-item"><h5 class="text-danger"><span>3～</span>男生可以在哪里看到女生的信息？看到了怎么联系？</h5>
                        <p class="text-warning">答：入会前，你可以在我们的官网13loveme.com的“最新觅约”版块的“今日觅约”、“往日觅约”和“十三救我”栏目查看各地区的女生，入会之前肯定是不能联系的哦；
                            入会后，你可以在会员号朋友圈和上述的官网都可以看到女生的信息，入户会可以根据你办理的相应会员权限进行报名。</p></li>
                <li class="list-group-item"><h5 class="text-danger"><span>4～</span>女生分布，哪些地区多？哪些地区少？</h5>
                    <p class="text-warning">答：国内所有的省会城市、一线城市、二线城市、大部分三四线城市（包括港澳台在内）都有十三女生会员，其中尤以北上广深江浙川渝为最多；
                        海外的话，在欧洲的英法德意西瑞士比利时波兰，亚洲的日韩、迪拜、新马泰，大洋洲的澳大利亚、新西兰，南美的巴西、阿根廷，北美的美国、加拿大，也都有我们的女会员。</li>
                <li class="list-group-item"><h5 class="text-danger"><span>5～</span>女生是怎么加入十三平台的？</h5>
                    <p class="text-warning">答：女生是和男生一样从我们的推广渠道看到，然后加到我们的，完成资料提交和交会费之后，女生也就完成入会的，男女平等哦~</p></li>
                <li class="list-group-item"><h5 class="text-danger"><span>6～</span>对于刚接触这类交友平台的男生，可以先免费试用吗？</h5>
                    <p class="text-warning">答：我们是不提供免费试用的，首先我们有各种官方微博、APP、微信公众号、网站等证明我们的真实性，其次我们有提供非常低价的会员可供尝试性入会。</p></li>
                <li class="list-group-item"><h5 class="text-danger"><span>7～</span>女会员是怎么看到男会员档案资料的？男生的档案是什么样子的？</h5>

                    <p class="text-warning">答：男生入会之后我们都会给个资料链接给你们填写，填写完提交我们审核，通过审核之后你的资料就会出现在该地区的男生档案里，该地区的女生就可以看到你啦~；
                        你的档案就是当时你填写的资料，我们以网页形式呈现给女生。</p>
                    </li>
                <li class="list-group-item"><h5 class="text-danger"><span>8～</span>怎么证明我们的真实性？</h5>

                    <p class="text-warning">答：我们有官方微博：十三交友官博，微信服务号：心动三十一天，微信订阅号：十三平台，官方网站：13loveme.com，这些都会发布很多平台活动、互动话题、原创文章、交友信息，足够让你信任我们；然后我们自主研发的APP：心动三十一天，已经上架并有不少真实用户，并且APP会不断更新新版本~</p>
                    </li>

            </ol>

            <h4 class="text-green">新人请仔细阅读，重复问题不再回答。谢谢。</h4>
        </div>
    </div>
</div>