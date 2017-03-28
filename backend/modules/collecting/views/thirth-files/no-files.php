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
<h3>点击下方一一解决</h3>
<div class="row">
<?php foreach ($diff as $item):
    $query = (new \yii\db\Query())->from('pre_collecting_files_text')->where(['id'=>$item])->one();
    if($query['status']==0){
        $status = "未填写或审核不通过";
    }elseif($query['status']==1){
        $status = "<span style='color:green;'>待审核中</span>";
    }elseif($query['status']==2){
        $status = "<span style='color:red;'>审核通过</span>";
    }else{
        $status = "<span style='color:blue;'>审核不通过，修改中</span>";
    }
    ?>
    <div class="col-md-3" style="min-height: 50px;padding:10px;text-align: left;">
        <a href="/collecting-file/thirth-files/view?id=<?=$query['id']?>">
            <div style="background-color: #fff;padding: 10px;">
                <h4>编号：<?=$query['id']?></h4>
                <h4>资料状态：<?=$status?></h4>
            </div>
        </a>
    </div>
<?php endforeach;?>
</div>