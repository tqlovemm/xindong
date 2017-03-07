<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    密约报名
                </h4>
            </div>
            <div class="modal-body text-center">
                <img style="width: 80px;border-radius: 50%;" id="data-avatar" class="img-responsive center-block" src="">
                <h5>妹子编号：<span id="data-number"></span></h5>
                <h3>所需节操币：<span id="data-worth" style="color:red;"></span></h3>
                <h3>节操币余额：<span id="data-total"><?=$total?></span></h3>
                <h6 class="hide" id='data-sum'></h6>
            </div>
            <div class="modal-footer">
                <button type="button" id="register__confirm" class="btn btn-default pull-left" style="color:red;padding-left:40px;padding-right: 40px;">确认</button>
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" style="padding-left:40px;padding-right: 40px;">取消</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="recharge" tabindex="-1" role="dialog" aria-labelledby="rechargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    警告
                </h4>
            </div>
            <div class="modal-body text-center">
                <h1>您的节操币不足</h1>
            </div>
            <div class="modal-footer">
                <a href="/member/user/jiecao-coin" class="btn btn-default pull-left" style="color:red;padding-left:40px;padding-right: 40px;">去充值</a>
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" style="padding-left:40px;padding-right: 40px;">取消</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="registered" tabindex="-1" role="dialog" aria-labelledby="rechargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    警告
                </h4>
            </div>
            <div class="modal-body text-center">
                <h2> 您已经报名。报名进度请查看约会记录</h2>
            </div>
            <div class="modal-footer">
                <a href="/member/user/dating-record" class="btn btn-default pull-left" style="color:red;padding-left:20px;padding-right: 20px;">查看约会记录</a>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="padding-left:40px;padding-right: 40px;">取消</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="different" tabindex="-1" role="dialog" aria-labelledby="differentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="differentModalLabel">
                    警告
                </h4>
            </div>
            <div class="modal-body text-center">
                <h3 id="data-content"></h3>
            </div>
            <div class="modal-footer">
                <a href="/member/user-show" class="btn btn-warning" style="padding-left:30px;padding-right: 30px;">去升级</a>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="padding-left:30px;padding-right: 30px;">取消</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script>

    $(function(){

        $(".content_link").removeAttr("href");

        $(".dating__signup",this).on('click',function(){

            $('#data-avatar').attr('src',$(this).attr('data-avatar'));
            $('#data-number').html($(this).attr('data-number'));
            $('#data-worth').html($(this).attr('data-worth'));
            $('#data-content').html($(this).attr('data-content'));
            $('#data-sum').html($(this).attr('data-sum'));

        });

        $("#register__confirm").on('click',function(){

            window.location.href = "/site/dating-signup-rewirte?number="+$('#data-number').html()+"&url=<?=urlencode(Yii::$app->request->url)?>&sum="+$('#data-sum').html();

        });

    });

</script>
