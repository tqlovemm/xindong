<h1>新入会没有档案照的编号</h1>
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
        <div style="background-color: #fff;padding: 10px;">
            <h4>编号：<?=$query['id']?></h4>
            <h4>资料状态：<?=$status?></h4>
        </div>
    </div>
<?php endforeach;?>
</div>