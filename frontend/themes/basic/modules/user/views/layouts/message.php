<?php

use yii\helpers\Url;
use yii\bootstrap\Nav;

$this->title=Yii::$app->user->identity->username.' - '.Yii::t('app', 'Notification');
?>
<?php $this->beginContent('@app/modules/user/views/layouts/user.php'); ?>
<div class="row inbox">
    <div class="col-sm-3" id="inbox-sidebar">

        <a id="write-inbox" data-toggle="modal" data-target="#myModals" class="btn btn-success btn-lg btn-block btn-write"><?= Yii::t('app', 'Compose') ?></a>
        <!-- 模态框（Modal） -->
        <div class="modal fade" id="myModals" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body text-center text-danger">
                        目前您只可对管理员发消息,你可以附上您的需求和您遇到的问题
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">关闭
                        </button>
                        <button type="button" class="btn btn-primary" onclick='window.location.href="<?= Url::toRoute(['/user/message/create']) ?>"'>
                            确定
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>


        <div class="box box-solid">
            <div class="box-body no-padding">
                <?= Nav::widget([
                    'items' => [
                        [
                            'label' => '<i class="glyphicon glyphicon-bell"></i> ' . Yii::t('app', 'Mention me'),
                            'url' => ['/user/message/mention'],
                        ],
                        [
                            'label' => '<i class="glyphicon glyphicon-inbox"></i> ' . Yii::t('app', 'Inbox') . '<span class="label label-danger pull-right">' . $this->params['count']['unread_message_count'] . '</span>',
                            'url' => ['/user/message/inbox'],
                        ],
                        [
                            'label' => '<i class="glyphicon glyphicon-send"></i> ' . Yii::t('app', 'Sent'),
                            'url' => ['/user/message/outbox']
                        ]
                    ],
                    'options' => ['id' => 'inbox-nav', 'class' =>'nav nav-pills nav-stacked'],
                    'encodeLabels' => false,
                ]); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-9" id="inbox-content">
        <div class="panel panel-default inbox-panel">
            <?php echo $content; ?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>
