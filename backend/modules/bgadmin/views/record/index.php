<?php
use yii\helpers\Url;
$week_array=array("日","一","二","三","四","五","六");
$this->registerCss("

    .opration{padding: 0 10px;background-color: #fff;margin-bottom: 10px;}
    .opration p{padding: 10px 0;margin: 0;}
    .opration p span{margin-right: 5px;margin-bottom:5px;border-radius: 2px;display:inline-block;padding:0 5px;}
    .opration .update span{margin-right: 5px;margin-bottom:5px;border-radius: 2px;display:inline-block;padding:0 5px;}

");

?>
<div class="container-fluid">
<div class="row" style="margin-top: 10px;">
    <ul class="list-group">
        <a class="inline list-group-item" style="display: inline-block;margin-bottom: 10px;" href="/bgadmin/record">全部</a>
        <?php foreach ($admins as $admin):?>
            <a class="inline list-group-item" style="display: inline-block;margin-bottom: 10px;<?php if(Yii::$app->request->get('id')==$admin['id']){ echo 'background-color:gray;color:#fff;'; }?>" href="<?=Url::toRoute(['view','id'=>$admin['id']])?>"><?=$admin['username']?></a>
        <?php endforeach;?>
   </ul>
</div>

<?php foreach($model as $item):?>
    <div class="row opration">
        <h4 style="margin: 0;border-bottom: 1px dashed #ddd;padding:8px 0;"><?=$item['username']?></h4>
        <p>
            <?=$item['description']?>
        </p>
        <?php if($item['type']==1):?>
            <h5 style="margin: 0;">增加数据</h5>
            <p>
                <?php foreach(json_decode($item['data'],true) as $key=>$value):?>
                    <span style="background-color: #81dd8c;">
                        <?=$key."=>".$value?>
                    </span>
                <?php endforeach;?>
            </p>
        <?php elseif($item['type']==2):?>
            <h5>删除数据</h5>
            <p>
                <?php foreach(json_decode($item['data'],true) as $key=>$value):?>
                    <span style="background-color: #ff92b8;">
                        <?=$key."=>".$value?>
                    </span>
                <?php endforeach;?>
            </p>
        <?php elseif($item['type']==3):
            $out1 = array_diff(json_decode($item['old_data'],true), json_decode($item['new_data'],true));
            $out2 = array_diff(json_decode($item['new_data'],true), json_decode($item['old_data'],true)); ?>
            <div class="update" style="margin: 0;padding:5px;">
                由：
                <?php foreach($out1 as $key=>$value):?>
                    <span style="background-color: #F4C8C8;">
                        <?=$key."=>".$value?>
                    </span>
                <?php endforeach;?>
                <br>改：
                <?php foreach($out2 as $key=>$value):?>
                    <span style="background-color: #f4b2b1;">
                        <?=$key."=>".$value?>
                    </span>
                <?php endforeach;?>
            </div>
        <?php else:?>
            <h5>查询数据</h5>
            <p>
                <?php foreach(json_decode($item['data'],true) as $key=>$value):?>
                    <span style="background-color: #e1c8f4;">
                        <?=$key."=>".$value?>
                    </span>
                <?php endforeach;?>
            </p>
        <?php endif;?>
            <h5 style="margin: 0;border-top: 1px dashed #ddd;padding:8px 0;"><?=date('Y-m-d H:i:s',$item['created_at'])?><?=' 星期'.$week_array[date('w')]?></h5>
        </div>

<?php endforeach;?>
<?= \yii\widgets\LinkPager::widget(['pagination' => $pages]); ?>
</div>