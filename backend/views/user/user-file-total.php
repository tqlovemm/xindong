<?php if(!empty($model)):?>
<table class="table table-bordered">
    <tr><th>编号</th><th>微信号</th><th>手机号</th><th>工作</th></tr>
    <tr><td><?=$model['id']?></td><td><?=$model['weichat']?></td><td><?=$model['cellphone']?></td><td><?=$model['job']?></td></tr>
    <tr><th>地址</th><th>生日</th><th>邮箱</th><th>常去地</th></tr>
    <tr><td><?=$model['address']?></td><td><?=date('Y-m-d',$model['age'])?></td><td><?=$model['email']?></td><td><?=$model['often_go']?></td></tr>
    <tr><th>身高</th><th>体重</th><th>喜欢类型</th><th>婚姻状况</th></tr>
    <tr><td><?=$model['height']?>cm</td><td><?=$model['weight']?>kg</td><td><?=$model['like_type']?></td><td><?=$model['marry']?>（0单身，1对象，2已婚）</td></tr>
</table>
    <div class="row">
        <?php foreach ($model['img'] as $img):?>
        <div class="col-xs-2"><img class="img-responsive" src="http://13loveme.com<?=$img['img'] ?>"></div>
        <?php endforeach;?>
    </div>
<?php else:?>
    <h1>暂无数据</h1>
<?php endif;?>
