<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\authentication\models\GirlAuthentication */

$this->title = 'Create Girl Authentication';
$this->params['breadcrumbs'][] = ['label' => 'Girl Authentications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="girl-authentication-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
