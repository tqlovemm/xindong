<?php
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\db\Query;
$this->registerCss("
    .dating-record .row .col-md-1{padding:0;}
");
$vip_check = new \frontend\modules\member\models\UserVipTempAdjust();
$pre_url = Yii::$app->params['shisangirl'];
?>

    <a href="http://13loveme.com/wei-xin/cjs" class="btn btn-success" target="_blank">刷新access_token</a><hr>
    <div id="member__search" class="form-group clearfix">
        <form action="dating-signup-check" method="get">
            <label for="name" class="pull-left" style="line-height: 34px;">查询类型：</label>
            <select name="type" class="form-control pull-left" style="width: 120px;">
                <option value="5">编号查询</option>
                <option value="4">ID查询</option>
            </select>
            <input class="form-control pull-left" name="user_id" style="width: 160px;" type="text" required placeholder="输入会员ID或者编号">
            <input class="pull-left btn btn-success" type="submit">
        </form>

        <a href="/dating/dating-content/dating-signup-check?type=1" class="pull-left btn btn-primary" style="margin: 0 10px 0 50px;">最新报名</a>
        <a href="/dating/dating-content/dating-signup-check?type=2" class="pull-left btn btn-primary" style="margin: 0 10px;">往日报名</a>
        <a href="/dating/dating-content/dating-signup-check?type=0" class="pull-left btn btn-primary" style="margin: 0 10px;">等待审核</a>
    </div>

    <div class="dating-record">

        <div class="row" style="margin:0;">
            <div class="col-md-3">男生ID、男生编号、金额、时间</div>
            <div class="col-md-4">妹子信息</div><div class="col-md-1">失败原因</div><div class="col-md-1">状态</div><div class="col-md-2" style="padding:0">操作</div><div class="col-md-1">处理人</div>
        </div>

        <?php foreach ($models as $model) :

            $number = Yii::$app->db->createCommand("select number from {{%user_profile}} where user_id={$model['user_id']}")->queryOne();
            $boy_number = $number['number'];
            $girl_info = json_decode($model['extra'],true);
            $weekly_id = (new Query)->select('id')->from("{{%weekly}}")->where(['number'=>$girl_info['number']])->one();
            $getImages = (new Query)->select('path')->from("{{%weekly_content}}")->where(['album_id'=>$weekly_id['id']])->all();

            switch($model['status']){
                case 9:
                case 10:
                    $op= "<span style='color:#372bff;'>等待中</span>";$color="none";break;
                case 11:$op="<span style='color:green;'>成功</span>";$color="rgba(0, 128, 0, 0.2)";break;
                default:$op="<span style='color:red;'>失败</span>";$color="rgba(255, 0, 0, 0.2)";
            }

            $groupid = (new Query())->select('groupid')->from("{{%user}}")->where(['id'=>$model['user_id']])->one();
            switch($groupid['groupid']){

                case 1:$grade = "网站会员";$color2="red";break;
                case 2:$grade = "普通会员";$color2="gray";break;
                case 3:$grade = "高端会员";$color2="blue";break;
                case 4:$grade = "至尊会员";$color2="orange";break;
                case 5:$grade = "私人订制";$color2="green";break;
                default:$grade = "";$color2="";
            }

            ?>

            <div class="row" style="background-color: <?=$color?>;border-bottom:1px solid red;margin-top: 10px;padding:5px;margin-left: 0;margin-right: 0;">
                <div class="col-md-3">
               <span><?=$model['user_id']?>、<?=$number['number']?>、<?=$model['number']?></span>
                <span style="color:red;"><?=date("m月d日 H:i",$model['updated_at'])?></span>
                <br>
                <br>
                    <strong style="color:<?=$color2?>;font-size: 20px;">
                    <?=$grade?>
                        <a class="btn btn-primary" onclick="window.open('/user/user-dating-total?type=1&ids=<?=$model['user_id']?>','','toolbar=no,status=0,location=no,resizable=yes,menubar=no,scrollbars=yes,top='+(window.screen.availHeight-600)/2+',left='+(window.screen.availWidth-1000)/2+',height=600,width=600')" style="color:#fff;cursor: pointer;">统计觅约</a>
                        <a class="btn btn-success" onclick="window.open('/user/user-file-total?number=<?=$number['number']?>','','toolbar=no,status=0,location=no,resizable=yes,menubar=no,scrollbars=yes,top='+(window.screen.availHeight-600)/2+',left='+(window.screen.availWidth-1000)/2+',height=600,width=600')" style="color:#fff;cursor: pointer;">男生资料</a>

                    </strong>
                    <?php
                        if(!empty($vip_check::findOne(['user_id'=>$model['user_id'],'status'=>10]))){
                            echo "<br><span style='color:red;font-size: 16px;'>该会员是试用升级会员，请优先处理</span>";
                        }
                    ?>


                </div>
                <div class="col-md-4">
                    <div class="row">
                    <div  class="col-md-4" style="padding:0">
                    <?php foreach($getImages as $item):?>
                        <a href="<?=$pre_url.$item['path']?>"  data-lightbox="d" data-title="<?=$girl_info['number']?>">
                            <img style="width: 56px;" src="<?=$pre_url.$item['path']?>">
                        </a>
                    <?php endforeach;?>
                    </div>
                        <div class="col-md-8" style="padding:0;padding-left:10px;">

                            <h6>编号：<?=$girl_info['number']?>&nbsp;&nbsp;&nbsp;&nbsp;妹子身价：<?=$girl_info['worth']?></h6>
                            <h6>标签：<?=$girl_info['mark']?></h6>
                            <h6>交友要求：<?=$girl_info['require']?></h6>
                            <?php
                            $number = json_decode($model->extra,true)['number'];
                            $r = \backend\modules\bgadmin\models\BgadminGirlMember::findOne(['number'=>substr($number,0,strlen($number)-2)]);
                            $member = empty($r)?\backend\modules\bgadmin\models\BgadminGirlMember::findOne(['number'=>$number]):$r;
                            if(!empty($member)){
                                $file = $member->getMemberText(0)->asArray()->one();
                                if(!empty($file)){
                                    if(!empty($file['memberFiles'])){
                                        echo "二维码：<a href=$pre_url{$file['memberFiles'][0]['path']}  data-lightbox='s' data-title='s'><img class='img-responsive img-thumbnail' style='width: 100px;height: 100px;' src=$pre_url{$file['memberFiles'][0]['path']}></a>";
                                        $weiuser = \frontend\modules\weixin\models\UserWeichat::findOne(['number'=>$boy_number]);
                                        if(!empty($weiuser)&&$model['platform']!=2):
                                            echo '<button onclick="pushweixin(this)" data-openid="'.$weiuser->openid.'" data-number="'.$girl_info['number'].'" class="btn btn-success">微信推送联系方式</button>';
                                            echo '<button onclick="deletepushweixin(this)" data-openid="'.$weiuser->openid.'" data-number="'.$girl_info['number'].'" class="btn btn-warning">清空记录重新推送</button>';
                                        elseif($model['status']==11&&$model['platform']==2):
                                            echo '<button onclick="pushapp(this)" data-openid="'.\backend\models\User::getUsername($model['user_id']).'" data-number="'.$pre_url.$file['memberFiles'][0]['path'].'" class="btn btn-success">APP推送联系方式</button>';
                                        endif;
                                    }else{

                                        echo "<span style='color:red;font-size: 18px;font-weight: bold;'>该女生无二维码。请为女生添加二维码或直接将二维码发送给该男生</span>";
                                    }

                                }else{

                                    echo "<span style='color:red;font-size: 18px;font-weight: bold;'>该女生无二维码。请为女生添加二维码或直接将二维码发送给该男生</span>";
                                }

                            }else{

                                echo "<span style='color:red;font-size: 18px;font-weight: bold;'>该女生无二维码。请为女生添加二维码或直接将二维码发送给该男生</span>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"><?=$model['reason']?></div>
                <div class="col-md-1"><?=$op?></div>
                <div class="col-md-2" style="padding:0">
                    <?php if($model['status']==10):?>
                        <button class="btn btn-success dating-fail" data-toggle="modal" data-status="11" data-id="<?=$model['id']?>" data-platform="<?=$model['platform']?>" data-op="成功原因,可以为空" data-target="#datingfaileModal">成功</button>
                        <button class="btn btn-danger dating-fail" data-toggle="modal" data-status="12" data-id="<?=$model['id']?>" data-platform="<?=$model['platform']?>" data-op="失败原因" data-target="#datingfaileModal">失败</button>
                        <button class="btn btn-warning dating-fail" data-toggle="modal" data-status="9" data-id="<?=$model['id']?>" data-platform="<?=$model['platform']?>" data-op="为什么转交" data-target="#datingfaileModal">转交组长</button>
                    <?php endif;?>
                    <?php if($model['platform']==2){
                        echo "<h4 style='color:red;'>此会员通过app端报名，请点击APP推送联系方式</h4>";
                    }?>
                </div>
                <div class="col-md-1"><?=$model['handler']?></div>
            </div>

        <?php endforeach;
            $this->registerJs("
              $('.dating-fail',this).on('click',function(){

                $('#dating-status').val($(this).attr('data-status'));
                $('#dating-id').val($(this).attr('data-id'));
                $('#dating-platform').val($(this).attr('dating-platform'));
                $('#dating_fail').attr('placeholder',($(this).attr('data-op')));
              });  

            "); ?>
    </div>
    <!-- 模态框（Modal） -->
    <div class="modal fade" id="datingfaileModal" tabindex="-1" role="dialog" aria-labelledby="datingfaileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="datingfaileModalLabel">操作原因</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="success-fail">
                        <input type="hidden" id="dating-status" name="status" class="form-control">
                        <input type="hidden" id="dating-id" name="id" class="form-control">
                        <input type="hidden" id="dating-platform" name="platform" class="form-control">
                        <textarea id="dating_fail" name="reason" placeholder="操作原因" class="form-control"></textarea>
                        <input type="submit" class="btn btn-danger" data-confirm="确认操作吗？" style="margin-top:20px;">
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
<script>

    function pushweixin(content){

        var con = $(content);
        $.get('send-temp?openid='+con.attr('data-openid')+'&number='+con.attr('data-number'),function (data) {
            var result = $.parseJSON(data);
            alert(result);
        });
    }
    function pushapp(content){

        var con = $(content);
        $.get('send-app?username='+con.attr('data-openid')+'&img='+con.attr('data-number'),function (data) {
            var result = $.parseJSON(data);
            alert(result.code);
        });
    }
    function deletepushweixin(content){

        var con = $(content);
        $.get('delete-push-record?openid='+con.attr('data-openid')+'&number='+con.attr('data-number'),function (data) {
            var result = $.parseJSON(data);
            alert(result);
        });
    }

</script>

<?=LinkPager::widget(['pagination' => $pages,]); ?>