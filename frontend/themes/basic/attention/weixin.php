<?php
$this->title='十三微信';

$this->registerCss('


    ');
?>
<div class="container">

    <div class="row">

        <div class="col-md-2">

            <?= $this->render('./attention-left')?>
        </div>
        <div class="col-md-9">
            <h1 class="text-center"><?=\yii\helpers\Html::encode($this->title)?></h1>

            <div class="panel-body">

                <div class="row">

                    <div class="col-md-4">
                        <img class="img-responsive center-block" src="/images/weixin/3.jpg">
                        <h3 class="text-center">十三平台微信公众号</h3>
                    </div>
                    <div class="col-md-4">
                        <img class="img-responsive center-block" src="/images/weixin/1.jpg">
                        <h3 class="text-center">十三平台女生入口</h3>
                    </div>
                    <div class="col-md-4">
                        <img class="img-responsive center-block" src="/images/weixin/2.jpg">
                        <h3 class="text-center">十三平台男生入口</h3>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

