<?php
$type = $_GET['stype'];
$msg = "[\"".$_GET['msg']."\"]";
$new = json_decode($msg,true);
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="initial-scale=1.0,maximum-scale=1.0, user-scalable=no, width=device-width" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>
        视频认证
    </title>
</head>
<style>
    body{ text-align:center}
    .img{
        margin-top: 50%;
    }
</style>
<body>
<div class="img">
    <?php
        if($type == 1){
            echo "<img src=\"/images/chenggong.png\" width=\"50\">";
        }else{
            echo "<img src=\"/images/Group.png\" width=\"50\">";
        }
    ?>
</div>
<p><strong><?php echo $new[0]; ?></strong></p>
</body>
</html>

