<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/30
 * Time: 11:20
 */
?>
<?php if(Yii::$app->session->hasFlash('success')):?>
    <?=Yii::$app->session->getFlash('success')?>
<?php endif;?>
<?php if(Yii::$app->session->hasFlash('warning')):?>
    <?=Yii::$app->session->getFlash('warning')?>
<?php endif;?>
<form action="vip-temp" method="get">

    <div class="input-group form-group">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button">会员编号：</button>
      </span>
        <input type="text" class="form-control" name="number" required>
    </div>
    <div class="input-group form-group">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button">会员等级：</button>
      </span>
        <select class="form-control" name="vip">
            <option value="3">高端会员</option>
            <option value="4">至尊会员</option>
        </select>
    </div>
    <div class="input-group form-group">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button">节操数量：</button>
      </span>
        <input class="form-control" type="number" name="coin" required>
    </div>
    <div class="form-group">
        <input class="btn btn-lg btn-primary" type="submit" value="提交">
    </div>

</form>
