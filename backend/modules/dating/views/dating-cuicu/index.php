<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\dating\models\DatingCuicuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dating Cuicus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dating-cuicu-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user_id',

            [
                'attribute' => '会员编号',
                'label' => '会员编号',
                'format' => 'raw',
                'value' => function ($data) {
                    $number = \backend\models\User::getNumber($data->user_id);
                    $url = "/user/user-file-total?number=$number";
                    return "<a class='btn btn-primary' href=$url target='_blank'>$number</a>";
                }
            ],
            [
                'attribute' => '女生编号',
                'label' => '女生编号',
                'value' => function ($data) {
                    return json_decode($data->record->extra,true)['number'];
                }
            ],

            [
                'attribute' => '会员要求',
                'format' => 'raw',
                'label' => '会员要求',
                'value' => function ($data) {
                    $number = \backend\models\User::getNumber($data->user_id);
                    if($data->type==0){
                        if($data->status==0){
                            return "催促客服加快处理 <a class='btn btn-success' target='_blank' href='/dating/dating-content/dating-signup-check?type=5&user_id=$number'>去处理</a>";
                        }else{
                            return "催促客服加快处理";
                        }

                    }elseif($data->type==2){
                        return "要求客服介入";
                    }

                }
            ],

            [
                'attribute' => 'status',
                'format' => 'raw',
                'label' => '处理结果',
                'value' => function ($data) {
                    if($data->status==0){
                        return "等待处理";
                    }elseif($data->status==1){
                        return "成功";
                    }else{
                        return "失败";
                    }
                }
            ],
            [
                'attribute' => 'reason',
                'label' => '处理记录',
                'value' => function ($data) {
                    return Html::encode($data->reason);
                }
            ],
            [
                'attribute' => '操作',
                'format' => 'raw',
                'label' => '操作',
                'value' => function ($data) {
                    if($data->status==0){
                        return "<a onclick='handel({$data->id})' class='btn btn-success' data-toggle='modal' data-target='#myModal'>还未处理</a>";
                    }else{
                        return "<a class='btn btn-warning'>$data->handler 已经处理</a>";
                    }
                }
            ],
            [
                'attribute' => '催促时间',
                'label' => '催促时间',
                'value' => function ($data) {
                    return date('Y-m-d H:i:s',$data->created_at);
                }
            ],
            [
                'attribute' => '处理时间',
                'label' => '处理时间',
                'value' => function ($data) {
                    return date('Y-m-d H:i:s',$data->updated_at);
                }
            ],
        ],
    ]); ?>

</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    处理结果
                </h4>
            </div>
            <div class="modal-body">
                <form action="/dating/dating-cuicu/do-cuicu" method="get">
                    <div class="radio">
                        <label>
                            <input type="radio" name="status" value=1 checked>处理成功
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="status" value=2>处理失败
                        </label>
                    </div>
                    <input id="hidden_id" type="hidden" name="id">
                    <div class="form-group">
                        <label for="name">备注</label>
                        <textarea title="备注信息" class="form-control" rows="3" name="reason" required></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                        </button>
                        <input class="btn btn-primary" type="submit" value="提交">
                    </div>
                </form>

            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script>

    function handel(id) {

        $('#hidden_id').val(id);

    }
</script>
<!--
<a class="btn btn-primary" onclick="window.open('/user/user-dating-total?type=1&ids=','','toolbar=no,status=0,location=no,resizable=yes,menubar=no,scrollbars=yes,top='+(window.screen.availHeight-600)/2+',left='+(window.screen.availWidth-1000)/2+',height=600,width=600')" style="color:#fff;cursor: pointer;">统计觅约</a>
<a class="btn btn-success" onclick="window.open('/user/user-file-total?number=','','toolbar=no,status=0,location=no,resizable=yes,menubar=no,scrollbars=yes,top='+(window.screen.availHeight-600)/2+',left='+(window.screen.availWidth-1000)/2+',height=600,width=600')" style="color:#fff;cursor: pointer;">男生资料</a>
-->