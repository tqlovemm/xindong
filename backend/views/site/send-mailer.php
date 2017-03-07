
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">发送邮件给：<span><?=$username?></span></h3>
            </div>
            <div class="panel-body">
                <form action="/index.php/site/send-mailer" method="post">
                    <div class="form-group">
                        <label>主题:</label>
                        <input class="form-control" type="text" name="object" value="<?=$moObj?>">
                        <input type="hidden" name="username" value="<?=$username?>">
                        <input type="hidden" name="email" value="<?=$email?>">
                    </div>
                    <div class="form-group">
                        <label>内容:</label>
                       <textarea rows="5" class="form-control" name="content"><?=$moContent?></textarea>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary pull-right" type="submit" name="提交">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

