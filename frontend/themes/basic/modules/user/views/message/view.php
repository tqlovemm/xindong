<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\Message */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['count'] = $count;
?>
<article class="inbox-read">
  <!-- Start .inbox-read -->

  <div class="inbox-info-bar">
    <p>
        <?= Html::a(Yii::t('app', 'Reply'), ['update', 'sendFrom' => $result2[0]['username']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
  </div>

    <header class="inbox-header" style="background-color: #e1fbed;padding:1px 15px;">
        <h3>主题：《<?= Html::encode($model->subject) ?>》</h3>
        <h5>发件人：<?= $result1[0]['username']?></h5>

        <h5>时　间：<?= Html::encode(date('Y年m月d日 H:i',$model->created_at));  ?></h5>
        <h5>发件人：<?= $result2[0]['username']?></h5>
    </header>

    <br>
  <div class="inbox-content clearfix" style="padding: 1px 15px;font-size: 16px;">
      <?= $model->content ?>
  </div>
</article>
