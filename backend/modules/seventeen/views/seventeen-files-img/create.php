<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\seventeen\models\SeventeenFilesImg */

$this->title = 'Create Seventeen Files Img';
$this->params['breadcrumbs'][] = ['label' => 'Seventeen Files Imgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seventeen-files-img-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
