<?php
    $this->title = Yii::$app->setting->get('siteName');
?>
<?php
$pass = floor((time()-$res['expire'])/86400);
if($pass>30):?>
<div class="row">
    <div class="col-md-4">
        <!-- Box Comment -->
        <div class="box box-widget">
            <div class="box-header with-border">
                <div class="user-block">
                    <img class="img-circle" src="<?=Yii::$app->user->identity->avatar?>" alt="User Image">
                    <span class="username"><a href="#"><?=Yii::$app->user->identity->nickname?></a></span>
                    <span class="description">上次修改密码时间：<?=date('Y-m-d H:i:s',$res['expire'])?></span>
                </div>
                <!-- /.user-block -->
                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read">
                        <i class="fa fa-circle-o"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <p style="color: red;font-size: 20px;">亲您已经<?=$pass?>天没有修改密码了，再不改老板就要生气了,赶快点我修改密码吧！</p>
                <a href="<?=\yii\helpers\Url::to(['/admin/user/change-password'])?>"><img class="img-responsive pad" src="/images/photo2.png" alt="Photo"></a>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
<?php endif;?>

