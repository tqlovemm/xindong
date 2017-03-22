<?php
use yii\widgets\LinkPager;
$pre_url = Yii::$app->params['threadimg'];
$pre =  Yii::$app->params['shisangirl'];
?>

<a href="http://13loveme.com/wei-xin/cjs" class="btn btn-success" target="_blank">刷新access_token</a>
<form action="/exciting/firefighters-sign-up" style="margin: 20px 0;">
    <input style="width: 10%;" class="form-control pull-left" type="text" placeholder="输入会员编号查询" name="number">
    <input class="btn btn-primary pull-left" type="submit">
    <div style="clear: both"></div>
</form>
<div class="row" style="margin: 10px 0;">
    <a href="/exciting/firefighters-sign-up?type=3" class="btn btn-primary">时间正序</a>
    <a href="/exciting/firefighters-sign-up?type=1" class="btn btn-primary">时间倒序</a>
    <a href="/exciting/firefighters-sign-up?type=0" class="btn btn-primary">等待审核</a>
    <a href="/exciting/firefighters-sign-up?type=2" class="btn btn-primary">已经审核</a>
    <a href="/exciting/firefighters-sign-up?type=4" class="btn btn-primary">编号排序</a>
    <a href="/exciting/firefighters-sign-up?type=5" class="btn btn-primary">未推送</a>
</div>

    <div class="row" style="background-color: #fff;padding: 5px;margin-bottom: 10px;">
        <div class="col-md-1">会员编号</div>
        <div class="col-md-1">报名ID</div>
        <div class="col-md-1">报名时间</div>
        <div class="col-md-4">内容信息</div>
        <div class="col-md-1">审核状况</div>
        <div class="col-md-1">原因</div>
        <div class="col-md-2">操作</div>
        <div class="col-md-1">操作人</div>
    </div>
<?php foreach($model as $key=>$val):
        $number = \backend\models\User::getNumber($val['user_id']);
        $groupid = (new \yii\db\Query())->select('groupid')->from("{{%user}}")->where(['id'=>$val['user_id']])->one();
    switch($groupid['groupid']){
        case 1:$grade = "网站会员";$color2="red";break;
        case 2:$grade = "普通会员";$color2="red";break;
        case 3:$grade = "高端会员";$color2="blue";break;
        case 4:$grade = "至尊会员";$color2="orange";break;
        case 5:$grade = "私人订制";$color2="green";break;
        default:$grade = "";$color2="";
    }

    ?>
    <div class="row" style="<?php if($val['status']==1):?>background-color: #a7eba0;<?php elseif($val['status']==2):?>background-color: #fad2d5;<?php else:?>background-color: #fff;<?php endif;?>padding: 5px;border-bottom: 1px solid #eee;">
        <div class="col-md-1">
            <?=$number?>
            <a onclick="window.open('/user/user-file-total?number=<?=$number?>','','toolbar=no,status=0,location=no,resizable=yes,menubar=no,scrollbars=yes,top='+(window.screen.availHeight-600)/2+',left='+(window.screen.availWidth-1000)/2+',height=600,width=600')" class="btn btn-primary">查看男生资料</a>
            <h4 style="color:<?=$color2?>;"><?=$grade?></h4>
        </div>
        <div class="col-md-1"><?=$val['sign_id']?></div>
        <div class="col-md-1">

            <time><?=date('Y-m-d H:i:s',$val['created_at'])?></time>

            <?php
                $success_count = \frontend\modules\weixin\models\FirefightersSignUp::find()->where(['number'=>$val['number']])->andWhere(['status'=>1])->count();
            ?>
            <h5 style="color: red;">审核成功：<?=$success_count?>人</h5>

        </div>

        <div class="col-md-4">
            <div class="row">
                <div class="col-xs-3"><img class="img-responsive" src="<?=$pre_url.$val['sign']['pic_path']?>"></div>
                <div class="col-xs-6" style="padding: 0">
                    <div class="">类型：<?php if($val['sign']['type']==3){echo '<span style="color:orange;">救火</span>';}else{echo '<span style="color:red;">福利</span>';}?></div>
                    <div class="">编号：<?=$val['sign']['number']?></div>
                    <div class="">地区：<?=$val['sign']['name']?></div>
                    <div class="">描述：<?=$val['sign']['content']?></div>
                    <div class="">节操币：<?=$val['sign']['coin']?></div>
                    <div class="">发布时间：<?=date('Y-m-d H:i:s',$val['sign']['created_at'])?></div>
                </div>
                <div class="col-xs-3">
                    <?php
                    $girl_number = $val['sign']['number'];
                    $r = \backend\modules\bgadmin\models\BgadminGirlMember::findOne(['number'=>$girl_number]);
                    $member = empty($r)?\backend\modules\bgadmin\models\BgadminGirlMember::findOne(['number'=>substr($girl_number,0,$girl_number-2)]):$r;
                    if(!empty($member)){

                        $file = $member->getMemberText(0)->asArray()->one();
                        if(!empty($file)){

                            if(!empty($file['memberFiles'])){
                                $weima_girl = $pre.$file['memberFiles'][0]['path'];
                                echo "<a href=$weima_girl}  data-lightbox='s' data-title='s'><img class='img-responsive img-thumbnail' style='width: 100px;height: 100px;' src={$weima_girl}></a>";
                                $weiuser = \frontend\modules\weixin\models\UserWeichat::findOne(['number'=>$number]);
                                if(!empty($weiuser)&&in_array($val['status'],[0,1])):
                                    echo '<button onclick="pushweixin(this)" data-openid="'.$weiuser->openid.'" data-number="'.$val['sign']['number'].'" class="btn btn-success">推送联系方式</button>';
                                    echo '<button onclick="deletepushweixin(this)" data-openid="'.$weiuser->openid.'" data-number="'.$val['sign']['number'].'" class="btn btn-warning">清空记录重新推送</button>';
                                endif;
                            }else{

                                echo "<span style='color:red;font-size: 18px;font-weight: bold;'>该女生无二维码。请为女生添加二维码或直接将二维码发送给该男生1</span>";
                            }

                        }else{

                            echo "<span style='color:red;font-size: 18px;font-weight: bold;'>该女生无二维码。请为女生添加二维码或直接将二维码发送给该男生2</span>";
                        }

                    }else{

                        echo "<span style='color:red;font-size: 18px;font-weight: bold;'>该女生无二维码。请为女生添加二维码或直接将二维码发送给该男生3</span>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-1"><?=$val['status']?>&nbsp;&nbsp;&nbsp;<small>（0等待审核，1审核通过，2审核不通过）</small></div>
        <div class="col-md-1"><?=$val['reason']?></div>
        <div class="col-md-2">
            <?php if($val['status']==0):?>
                <a class="btn btn-success" href="/exciting/firefighters-sign-up/pass-or-not?id=<?=$val['id']?>&status=1">通过</a>
                <a class="btn btn-danger dating-fail" data-target="#datingfaileModal"  data-toggle="modal"  data-status="2" data-id="<?=$val['id']?>">不通过</a>
            <?php endif;?>
            <?php if($val['status']==1):?>
                <a class="btn btn-danger" data-confirm="确定撤销吗，撤销会返还所有节操币" href="/exciting/firefighters-sign-up/reback?id=<?=$val['id']?>&status=2">撤销</a>
            <?php endif;?>
        </div>
        <div class="col-md-1"><?=$val['handler']?></div>
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
                    <form method="get" action="/exciting/firefighters-sign-up/pass-or-not">
                        <input type="hidden" id="dating-status" name="status" class="form-control">
                        <input type="hidden" id="dating-id" name="id" class="form-control">
                        <textarea id="dating_fail" name="reason" placeholder="操作原因" class="form-control"></textarea>
                        <input type="submit" class="btn btn-danger" data-confirm="确认操作吗？" style="margin-top:20px;">
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
<?php endforeach;
        $this->registerJs("
          $('.dating-fail',this).on('click',function(){

            $('#dating-status').val($(this).attr('data-status'));
            $('#dating-id').val($(this).attr('data-id'));
            $('#dating_fail').attr('placeholder',($(this).attr('data-op')));
          });  

            "); ?>
    <script>

        function pushweixin(content){

            var con = $(content);
            $.get('/exciting/firefighters-sign-up/send-temp?openid='+con.attr('data-openid')+'&number='+con.attr('data-number'),function (data) {
                var result = $.parseJSON(data);
                alert(result);
            });
        }
        function deletepushweixin(content){

            var con = $(content);
            $.get('/exciting/firefighters-sign-up/delete-push-record?openid='+con.attr('data-openid')+'&number='+con.attr('data-number'),function (data) {
                var result = $.parseJSON(data);
                alert(result);
            });
        }

    </script>

<?= LinkPager::widget(['pagination' => $pages]); ?>