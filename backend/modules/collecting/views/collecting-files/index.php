<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\collecting\models\Collecting17FilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '十七平台女生档案';
$this->params['breadcrumbs'][] = $this->title;
?>
<form class="form-group" action="/collecting-file/collecting-files/excel" method="get">
    <label>选择起始结束时间</label>
    <br>
    <input required class="form-control pull-left" style="width: 200px;" name="start_time" type="date">
    <input required class="form-control pull-left" style="width: 200px;" name="end_time" type="date">
    <button class="btn btn-default" type="submit">导出选定日期的女生</button>
</form>
<button class="btn btn-primary" onclick="exportFile(1)">导出全部女生</button>
<button class="btn btn-success" onclick="exportFile(2)">导出一周内女生</button>
<button class="btn btn-warning" onclick="exportFile(3)">导出一个月内女生</button>
<div class="collecting17-files-text-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                'address_province',
                'weichat',
                'cellphone',
                'address_province',
                'address_city',
                'status',
                'updated_at:datetime',
                ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update} {delete}'],
            ],
        ]); ?>
</div>
<script>
    function exportFile(type) {
        location.href = '/collecting-file/collecting-files/excel?type='+type;
    }
</script>