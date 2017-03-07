<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\ScanWeimaDetail */

$this->title = 'Create Scan Weima Detail';
$this->params['breadcrumbs'][] = ['label' => 'Scan Weima Details', 'url' => ['index']];
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