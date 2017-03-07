<table class="table table-bordered">
    <tbody>
    <tr><td>投诉ID</td><td>投诉用户名</td><td>帖子ID</td><td>投诉描述</td><td>投诉时间</td><td>操作</td></tr>
        <?php foreach($result as $res):?>
            <tr><td><?=$res['id']?></td>
                <td><?=$res['username']?></td>
                <td><?=$res['thread_id']?>&nbsp;&nbsp;<a href="http://www.13loveme.com/index.php/thread/<?=$res['thread_id']?>" target="_blank">查看帖子</a></td>
                <td><?=$res['description']?></td>
                <td><?=date('Y-m-d H:i:s',$res['created_at'])?></td>
                <td><a href="/index.php/site/pclaims-delete?id=<?=$res['id']?>" data-confirm="确认删除吗？？">删除</a>&nbsp;&nbsp;&nbsp;<a href="/index.php/site/send-mailer?username=<?=$res['username']?>&email=<?=$res['email']?>">邮件</a></td>
            </tr>
        <?php endforeach;?>
    <?php


    ?>
    </tbody>
</table>