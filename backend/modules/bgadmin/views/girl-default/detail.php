<?php
$this->registerCss("
    body,html,.login-page, .register-page{background-color:#fff;}
");
$pre_url = Yii::$app->params['shisangirl'];
if(Yii::$app->request->get('type')==1):
?>
<table class="table table-bordered">
    <tr><td>编号</td><td>觅约创建时间</td><td rowspan="4"><img style="width: 90px;" src="<?=$date->avatar?>"></td></tr>
    <tr><th><?=$date->number?></th><th><?=date('Y/m/d',$date->created_at)?></th></tr>
    <tr><td>标签</td><td>交友要求</td></tr>
    <tr></th><th><?=$date->content?></th><th><?=$date->url?></th></tr>
    <tr><td colspan="3">简介</td></tr>
    <tr><th colspan="3" style="height: 140px;"><?=$date->introduction?></th></tr>
</table>
<div class="row">
    <?php foreach ($photos['photos'] as $photo):?>
    <div class="col-xs-4"><a href="<?=$photo['path']?>" data-lightbox="d" data-title="s"><img class="img-responsive" src="<?=$photo['path']?>"></a></div>
    <?php endforeach;?>
</div>
<?php else:?>
    <table class="table table-bordered">
        <tr><td>编号</td><td>觅约创建时间</td><td>微信号</td></tr>
        <tr><th><?=$date->id?></th><th><?=date('Y/m/d',$date->created_at)?></th><th><?=$date->weichat?></th></tr>
        <tr><td>手机号</td><td>微博号</td><td>qq</td></tr>
        <tr><th><?=$date->cellphone?></th><th><?=$date->weibo?></th><th><?=$date->qq?></th></tr>
        <tr><td>年龄</td><td>性别(0:男，1:女)</td><td>身高 / 体重</td></tr>
        <tr><th><?=date('Y-m-d',$date->age)?></th><th><?=$date->sex?></th><th><?=$date->height?>cm / <?=$date->weight?>kg</th></tr>
        <tr><td>婚否<small>（0单身，1有女朋友，2已婚）</small></td><td>工作职业</td><td>兴趣爱好</td></tr>
        <tr><th><?=$date->marry?></th><th><?=$date->job?></th><th><?=$date->hobby?></th></tr>
        <tr><td>喜欢妹子类型</td><td>车型</td><td>年薪</td></tr>
        <tr><th><?=$date->like_type?></th><th><?=$date->car_type?></th><th><?=$date->annual_salary?></th></tr>
        <tr><td>地区</td><td colspan="2">审核通过情况</td></tr>
        <tr><th><?=$date->address?></th><th colspan="2"><?=$date->status?><small> (0未填写，1已填等待审核中，2审核通过，3未通过修改中)</small></th></tr>
        <tr><td colspan="4">备注简介</td></tr>
        <tr><th colspan="4"><?=$date->extra?></th></tr>
    </table>
    <div class="row">
        <?php foreach ($photos as $photo):?>
            <div class="col-xs-4"><a href="<?=$pre_url.$photo['img']?>" data-lightbox="d" data-title="s"><img class="img-responsive" src="<?=$pre_url.$photo['img']?>"></a></div>
        <?php endforeach;?>
    </div>

<?php endif;?>
