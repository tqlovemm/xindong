<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\ScanWeimaDetail */

$this->title = 'Create Channel Weima';
$this->params['breadcrumbs'][] = ['label' => 'Channel Weima', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scan-weima-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php if(!empty($weima)):?>
    <?=$weima?>
<?php endif;?>