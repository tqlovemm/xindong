<div class="row" style="padding: 10px;background-color: #fff;border-bottom: 1px solid red;">
    <div class="col-md-2">ID</div>
    <div class="col-md-2">会员ID</div>
    <div class="col-md-2">会员编号</div>
    <div class="col-md-2">升级等级</div>
    <div class="col-md-2">使用时间</div>
    <div class="col-md-2">状态</div>

</div>
<?php foreach ($model as $item):?>

    <div class="row" style="padding: 10px;background-color: #fff;border-bottom: 1px solid gray;">
        <div class="col-md-2"><?=$item['id']?></div>
        <div class="col-md-2"><?=$item['user_id']?></div>
        <div class="col-md-2"><?=\backend\models\User::getNumber($item['user_id'])?></div>
        <div class="col-md-2"><?=$vip = ($item['vip']==3)?'高端':'至尊'?></div>
        <div class="col-md-2"><?=date('Y-m-d',$item['created_at'])?></div>
        <div class="col-md-2"><?=$status = ($item['status']==10)?"正常":'失效';?></div>

    </div>

<?php endforeach;?>
