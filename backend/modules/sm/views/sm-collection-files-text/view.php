<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\sm\models\SmCollectionFilesText */
/*echo '<pre>';
return var_dump($model);*/
$this->title = $model['member_id'];
$this->params['breadcrumbs'][] = ['label' => 'Sm Collection Files Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$pre_url = Yii::$app->params['localandsm'];
?>
<div class="sm-collection-files-text-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model['member_id']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model['member_id']], [
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
            'member_id',
            'weichat',
            'qq',
            'cellphone',
            'weibo',
            'email:email',
            'vip',
            'address',
            'birthday',
            [                      // the owner name of the model
                'label' => 'sex',
                'value' => ($model['sex']==0)?"男":"女",
            ],
            'height',
            'weight',
            [                      // the owner name of the model
                'label' => 'marry',
                'value' => ($model['marry']==0)?"未婚":"已婚",
            ],
            'job',
            'hobby',
            'car_type',
            'extra',
            //'created_at:datetime',
            [                      // the owner name of the model
              'label' => 'created_at',
              'value' => date('Y-m-d :H:i:s',$model['created_at']),
            ],
            [
                'label'=>'flag',
                'value'=>"http://13loveme.com/sm?id=".$model['flag'],
            ],
            [
                'label'=>'status',
                'value'=>($model['status']==0)?"未填写":"已填写",
            ],
            'often_go',
            'annual_salary',

        ],
    ]) ?>

</div>
<div class="row">
    <?php foreach ($model['img'] as $img):?>
        <div class="col-xs-2">
            <img class="img-responsive" src="<?=$pre_url.$img['img_path']?>">

            <?= Html::a('Delete', ['delete-img', 'id' => $img['img_id']], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>

        </div>
    <?php endforeach;?>
</div>