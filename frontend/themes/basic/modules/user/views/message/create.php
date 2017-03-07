<?php

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Message',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['inbox']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['count'] = $count;
?>
<div class="message-create">
    <?php
        if(!empty($from)){

           echo  $this->render('_form', [
                'model' => $model,
                'from'=>$from,
            ]);

        }else{
            echo $this->render('_form', [
                'model' => $model,
            ]);
        }
    ?>

</div>
