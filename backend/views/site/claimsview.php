<?php
use yii\helpers\Html;
?>

<table class="table table-bordered table-hover" align="center">
    <tr>
        <?php

        foreach($claimsones as $claimsone):
        ?>

    <tr>
        <th width="100">投诉者：</th><td width="900"><?=$claimsone['created_by']?></td>
    </tr> <tr>
        <th width="100">投诉对象：</th><td width="900"><?=$claimsone['claims_to']?></td>
    </tr> <tr>
        <th>投诉时间：</th><td><?=date('Y-m-d H:i:s',$claimsone['created_at'])?></td>
    </tr> <tr>
        <th>投诉原因：</th><td><?=Html::encode($claimsone['title'])?></td>
    </tr> <tr>
        <th>投诉内容：</th><td style="word-break:break-all"><?=Html::encode($claimsone['content'])?></td>
    </tr><tr>
        <th>附件：</th><td><img src="<?='/uploads/claims/'.$claimsone['file']?>" width="100%"></td>
    </tr>


    <?php
    endforeach;
    ?>

</table>

