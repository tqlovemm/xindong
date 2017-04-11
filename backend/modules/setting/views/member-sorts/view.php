<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
$pre_url = Yii::$app->params['threadimg'];
/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\MemberSorts */

$this->title = "会员种类";
$this->params['breadcrumbs'][] = ['label' => '会员种类', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-sorts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('上传图片', ['upload', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'member_name',
            'member_introduce',
            'price_1',
            'price_2',
            'price_3',
            'discount',
        ],
    ]) ?>

</div>
<div class="row" style="margin: 0;">
    <?php foreach ($model->img as $img):
        $type = "";
        if($img['type']==0){
            $type = "简介图片";
        }elseif($img['type']==1){
            $type = "封面图片";
        }elseif($img['type']==2){
            $type = "顶部封面";
        }
        ?>
    <div class="col-md-2" style="padding-left: 0;">
        <img class="img-responsive" src="<?=$pre_url.$img['img_path']?>">
        <span>类型：<?=$type?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>排序：<?=$img['sort']?></span><br>
        <?= Html::a('设置类型', ['set-img', 'id' => $img['id']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除图片', ['delete-img', 'id' => $img['id'],'sort_id'=>$model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <?php endforeach;?>
</div>
