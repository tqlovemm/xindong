<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\home\models\Album */

$this->title = '创建密约';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Seeks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="album-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
