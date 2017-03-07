<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Board */

$forum = $model->forum;
$this->params['forum'] = $forum;

?>
<div class="col-xs-12 col-sm-12">
    <div class="widget-container">

        <!-- 按钮触发模态框 -->
        <button class="btn btn-success pull-right" data-toggle="modal"
                data-target="#myModal">
            我要发帖
        </button>

        <!-- 模态框（Modal） -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>


                        <?= $this->render('/thread/_form', [
                            'model' => $newThread,
                            'forumName' => $forum['forum_name']
                        ]) ?>



                        <div class="modal-footer">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal">关闭
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal -->
            </div>


        </div>


    </div>
</div>
<hr>
<?php
if (!$model->isOneBoard()):
    $this->title = $model->name . '_' . $forum['forum_name'];

    echo '<div class="col-xs-12 col-sm-12">';
    echo '<div class="widget-container">';
endif;
?>
<div class="col-xs-12 col-sm-12"><div class="widget-container">
    <?= $this->render('_threads', [
        'threads' => $model->threads['threads'],
        'model' => $model,
    ]) ?>

</div></div>

<?php if (!$model->isOneBoard()) echo '</div></div>'; ?>

