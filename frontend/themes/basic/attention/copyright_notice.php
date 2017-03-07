
<?php

    $this->title='版权申明';

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
            <ul class="list-group attention">
               <li class="list-group-item">苏州三十一天网络科技公司对其发行的或与合作公司共同发行的包括但不限于产品或服务的全部内容及网站上的材料拥有版权等知识产权，受法律保护。</li>
               <li class="list-group-item">未经本公司书面许可，任何单位及个人不得以任何方式或理由对上述产品、服务、信息、材料的任何部分进行使用、复制、修改、抄录、传播或与其它产品捆绑使用、销售。</li>
               <li class="list-group-item">凡侵犯本公司版权等知识产权的，本公司必依法追究其法律责任。</li>
               <li class="list-group-item">本公司法律事务部受本公司指示，特此郑重法律声明！</li>
            </ul>
        </div>
    </div>
</div>