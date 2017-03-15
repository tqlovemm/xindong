

<div class="container">
    <div class="row"><a class="btn btn-default" href="/flop/flop">返回</a></div>
    <div class="row">
    <table class="table table-bordered flop-data-table">
        <tr>
            <td>ID</td><td>User ID</td><td>喜欢</td><td>翻牌</td><td>时间</td><td>唯一标示</td><td>操作</td>
        </tr>

        <?php foreach($model as $item):
            $content = explode(',',$item['content']);
            $priority = explode(',',$item['priority']);
            ?>

            <tr>
                <td><?=$item['id']?></td>
                <td><?=$item['user_id']?></td>
                <td>
                    <?php foreach($content as $list):?>
                        <?=$list?>
                    <?php endforeach;?>
                </td>
                <td>
                    <?php foreach($priority as $list):?>
                        <?=$list?>
                    <?php endforeach;?>
                </td>
                <td><?=date('m/d',$item['created_at'])?></td>
                <td><?=$item['flag']?></td>
                <td><a href="/flop/flop/flop-data-delete?id=<?=$item['id']?>" class="glyphicon glyphicon-trash"></a> <a href="/flop/flop/flop-data-view?id=<?=$item['id']?>" class="glyphicon glyphicon-eye-open"></a></td>
            </tr>
        <?php endforeach;?>
        </table>
</div>


</div>
