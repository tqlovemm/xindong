<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\LinkPager;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '相册';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCss('
    .pagination{position: absolute;top:50%;left:35%;}

');
?>

<div class="album-index" style="">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(Yii::$app->user->id=='10000'):?>
    <p>
        <?= Html::a('创建相册', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif;?>
    <?= ListView::widget([
        'layout' => "{items}\n{pager}",
        'itemView' => '_album',
        'dataProvider' => $dataProvider,
    ]); ?>


</div>
