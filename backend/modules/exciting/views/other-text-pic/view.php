<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\weekly\models\WeeklyContent */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Weekly Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$pre_url = Yii::$app->params['threadimg'];
?>
<div class="weekly-content-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->pid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->pid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

        <?php if(in_array($model->type,[3,4])) {
            echo Html::a('查看女生及二维码是否存在', ['create-bg', 'pid' => $model->pid], ['class' => 'btn btn-warning']);
        }
        ?>
        <?php if(in_array($model->type,[3])) {
            echo Html::a('群发地区推送', ['firefighters-sign-up/send-temp-to-all', 'number'=>$model->number, 'pid' => $model->pid, 'name'=>$model->name], ['class' => 'btn btn-danger']);
        }
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'pid',
            'tid',
            'number',
            'name',
            'content',
            [
                'format'=>'raw',
            'label' => 'pic_path',
            'value' => "<img src=$pre_url$model->pic_path />",
            ],
            'created_at:datetime',
        ],
    ]) ?>

</div>
