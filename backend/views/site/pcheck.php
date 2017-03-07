
<?php
    date_default_timezone_set("Asia/Shanghai");
    $path = Yii::getAlias('@web').'/images/avatar';

?>
<table class="table table-bordered text-center">

    <tr><th>用户ID</th><th>用户名</th><th>用户头像</th><th>修改时间</th><th colspan="2">审核情况</th></tr>
    <?php
       foreach($forums as $forum){?>

           <tr>
               <td style="vertical-align: middle;"><?=$forum['id']?></td>
               <td style="vertical-align: middle;"><?=$forum['username']?></td>
               <td><img src="<?=$path.'/'.$forum['avatartemp']?>" width="100" height="100"></td>
               <td style="vertical-align: middle;"><?=date('Y-m-d H:i:s',$forum['updated_at'])?></td>
               <td style="vertical-align: middle;"><a class="btn btn-success"  onclick="window.location.href='/index.php/site/pass?id=<?=$forum['id']?>'">通过</a></td>
               <td style="vertical-align: middle;"><a class="btn btn-danger" onclick="window.location.href='/index.php/site/npass?id=<?=$forum['id']?>'">不通过</a></td>
           </tr>

    <?php
    }
    ?>



</table>

