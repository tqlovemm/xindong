<?php
use yii\helpers\Html;

$this->registerCss('
    #banner-other{background-color:#fff;}
    li a{padding:10px 30px;}
');
?>
<ul id="banner-other" class="list-group">

    <li class="list-group-item <?php if(Yii::$app->request->getPathInfo()=='attention/copyright_notice'){echo 'list-group-item-warning';} ?>"><?=Html::a('版权申明','/attention/copyright_notice')?></li>
    <li class="list-group-item <?php if(Yii::$app->request->getPathInfo()=='attention/disclaimer'){echo 'list-group-item-warning';} ?>"><?=Html::a('免责申明','/attention/disclaimer')?></li>
    <li class="list-group-item <?php if(Yii::$app->request->getPathInfo()=='attention/problem'){echo 'list-group-item-warning';} ?>"><?=Html::a('常见问题','/attention/problem')?></li>
    <li class="list-group-item <?php if(Yii::$app->request->getPathInfo()=='attention/privacy'){echo 'list-group-item-warning';} ?>"><?=Html::a('关于隐私','/attention/privacy' )?></li>
    <li class="list-group-item <?php if(Yii::$app->request->getPathInfo()=='attention/weixin'){echo 'list-group-item-warning';} ?>"><?=Html::a('十三微信','/contact' )?></li>
    <li class="list-group-item <?php if(Yii::$app->request->getPathInfo()=='attention/cooperation'){echo 'list-group-item-warning';} ?>"><?=Html::a('商务合作','/attention/cooperation' )?></li>

</ul>