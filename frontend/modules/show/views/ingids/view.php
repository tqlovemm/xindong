<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\show\models\Seeks */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'In ID照', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCss('

.seeks-view{text-align:center;}
.seeks-view img{max-width:100%;display:block;margin:auto;}
.container-fluid{padding:0;}
');
?>
<div class="seeks-view">

    <?php if(Yii::$app->user->id==10000):?>
    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你确定删除吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php endif;?>
    <?= DetailView::widget([

        'model' => $model,

        'attributes' => [
            'path:image',
            'name',
            'thumb',
            'created_at:datetime',
        ],
        'template' => '<tr><td>{value}</td></tr>',

    ]) ?>

</div>
