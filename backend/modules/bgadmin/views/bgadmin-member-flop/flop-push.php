<?php use yii\widgets\LinkPager;?>
    <div class="row" style="padding:20px 0;">
        <div class="col-md-1">被翻牌男生</div>
        <div class="col-md-4">翻牌女生</div>
        <div class="col-md-2">创建时间</div>
        <div class="col-md-2">创建人</div>
    </div>
<?php foreach($model as $key=>$val):?>
    <div class="row" style="padding:10px 0;background-color: #fff;border-bottom: 1px solid #eee;">
        <div class="col-md-1"><?=$val['floped_number']?></div>
        <div class="col-md-4">
            <?=$val['floping_number']?>
            <?php
            $member = \backend\modules\bgadmin\models\BgadminMember::findOne(['number'=>$val['floping_number']]);
            if(!empty($member)){
                $file = $member->getMemberText(0)->asArray()->one();
                if(!empty($file)){

                    if(!empty($file['memberFiles'])){
                        echo "<a href=http://13loveme.com:82/{$file['memberFiles'][0]['path']}  data-lightbox='s' data-title='s'><img class='img-responsive img-thumbnail' style='width: 100px;height: 100px;' src=http://13loveme.com:82/{$file['memberFiles'][0]['path']}></a>";
                        $weiuser = \frontend\modules\weixin\models\UserWeichat::findOne(['number'=>$val['floped_number']]);
                        if(!empty($weiuser)):
                            echo '<button onclick="pushweixin(this)" data-openid="'.$weiuser->openid.'" data-number="'.$val['floping_number'].'" class="btn btn-success">推送联系方式</button>';
                            echo '<button onclick="deletepushweixin(this)" data-openid="'.$weiuser->openid.'" data-number="'.$val['floping_number'].'" class="btn btn-warning">清空记录重新推送</button>';
                        else:
                            echo "<div style='color:blue;font-size: 14px;font-weight: bold;'>该男生未进行微信认证，建议男生微信认证，或直接将二维码发送给该男生。</div>";
                        endif;
                    }else{

                        echo "<div style='color:red;font-size: 14px;font-weight: bold;'>该女生无二维码。请为女生添加二维码或直接将二维码发送给该男生</div>";
                    }

                }else{

                    echo "<div style='color:red;font-size: 14px;font-weight: bold;'>该女生无二维码。请为女生添加二维码或直接将二维码发送给该男生</div>";
                }

            }else{

                echo "<div style='color:red;font-size: 14px;font-weight: bold;'>该女生无二维码。请为女生添加二维码或直接将二维码发送给该男生</div>";
            }
            ?></div>

        <div class="col-md-2"><?=date('Y-m-d H:i:s',$val['created_at'])?></div>
        <div class="col-md-2"><?=$val['created_by']?></div>
    </div>
<?php endforeach;?>

<?= LinkPager::widget(['pagination' => $pages]); ?>
<script>

    function pushweixin(content){

        var con = $(content);
        $.get('/bgadmin/bgadmin-member-flop/send-temp?openid='+con.attr('data-openid')+'&number='+con.attr('data-number'),function (data) {
            var result = $.parseJSON(data);
            alert(result);
        });
    }
    function deletepushweixin(content){

        var con = $(content);
        $.get('/bgadmin/bgadmin-member-flop/delete-push-record?openid='+con.attr('data-openid')+'&number='+con.attr('data-number'),function (data) {
            var result = $.parseJSON(data);
            alert(result);
        });
    }

</script>
