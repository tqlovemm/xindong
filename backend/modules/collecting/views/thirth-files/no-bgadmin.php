<div class="row" style="margin-bottom: 50px;">
    <div class="col-md-4">
        <a class="btn btn-lg btn-default" style="<?php if(Yii::$app->request->get('id')==4){echo 'background-color:#ff8982;';} ?>" href="have-no-file?id=4"> 入会无翻牌档案编号</a>
    </div>
    <div class="col-md-4">
        <a class="btn btn-lg btn-default" style="<?php if(Yii::$app->request->get('id')==2){echo 'background-color:#ff8982;';} ?>" href="have-no-flop?id=2">存在于翻牌不存在于跟踪列表</a>
        <a href="http://13loveme.com/alipaies/ms" class="btn btn-lg btn-success" target="_blank">点此同步</a>
    </div>
    <div class="col-md-4">
        <a class="btn btn-lg btn-default" style="<?php if(Yii::$app->request->get('id')==3){echo 'background-color:#ff8982;';} ?>" href="have-no-follow?id=3">存在于档案表不存在于跟踪列表</a>
        <a href="http://13loveme.com/alipaies/d" class="btn btn-lg btn-success" target="_blank">点此同步</a>
    </div>
</div>
<h3>点击对应按钮旁的同步按钮，打开页面不要关闭让其自动刷新，直到没有数据为止</h3>
<div class="row">
<?php foreach ($diff as $item):?>
    <div class="col-md-3" style="min-height: 50px;padding:10px;text-align: left;">
        <div style="background-color: #fff;padding: 10px;">
            <h4>编号：<?=$item?></h4>
        </div>
    </div>
<?php endforeach;?>
</div>