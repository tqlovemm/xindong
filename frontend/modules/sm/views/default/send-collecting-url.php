<div class="container">
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            <h3>会员编号：<?=$model->member_id?></h3>
            <h5>生成时间：<?=date('Y-m-d H:i:s',$model['created_at'])?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            <textarea id="copy_url" rows="5" class="form-control text-center"><?=$url?><?=$model->flag?></textarea>
        </div>
    </div>
</div>