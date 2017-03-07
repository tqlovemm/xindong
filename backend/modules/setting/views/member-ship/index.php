<?php
    use yii\helpers\Html;
?>
<div class="row">
    <div class="col-md-6">
        <form method="post" action="/index.php/setting/member-ship">
            <div class="form-group">
                <label>会员编号：</label>
                <input class="form-control" type="text" name="member-number">
            </div>
            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="搜索">
            </div>
        </form>
    </div>
</div>
<h2><?= Html::a('创建会员信用', ['credit-value/create'], ['class' => 'btn btn-success']) ?></h2>
<?php if(Yii::$app->session->hasFlash('empty')):?>
<div class="row">
    <h3>查询会员编号：<?=$number?></h3>
    <h5 class="alert alert-warning"><?=Yii::$app->session->getFlash('empty')?></h5>
</div>
<?php endif;?>
<?php if(!empty($model)):?>
<div class="row">
    <table class="table table-bordered text-center">
        <tr>
            <td>会员ID</td>
            <td>会员等级分</td>
            <td>会员粘度分</td>
            <td>语言技巧分</td>
            <td>羞羞技巧分</td>
            <td>外貌形象分</td>
            <td>操作</td>
        </tr>
        <tr>
            <td><?=$model['user_id']?></td>
            <td><?=$model['levels']?></td>
            <td><?=$model['viscosity']?></td>
            <td><?=$model['lan_skills']?></td>
            <td><?=$model['sex_skills']?></td>
            <td><?=$model['appearance']?></td>
            <td>
                <a href="credit-value/update?id=<?=$model['id']?>" class="btn btn-primary">修改 </a>
                <?= Html::a('删除', ['credit-value/delete', 'id' => $model['id']], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => '确定删除吗?',
                        'method' => 'post',
                    ],
                ]) ?></td>
        </tr>
    </table>
</div>

<?php endif;?>