<?php
use yii\widgets\LinkPager;

?>

<table class="table table-bordered">
    <tbody>

    <tr><td></td></tr>


    </tbody>
</table>
<?php foreach ($models as $model) :?>

    <?=var_dump($model)?>

<?php endforeach; ?>


<?=LinkPager::widget(['pagination' => $pages,]); ?>


