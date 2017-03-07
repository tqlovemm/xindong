<?php
use frontend\models\RechargeRecord;
/* *
 * 功能：支付宝页面跳转同步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************页面功能说明*************************
 * 该页面可在本机电脑测试
 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
 * 该页面可以使用PHP开发工具调试，也可以使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyReturn
 */
use shiyang\alipaywap\AlipayConfig;
use shiyang\alipaywap\lib\AlipayNotify;
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php
    //计算得出通知验证结果
    $alipay_config = (new AlipayConfig())->getConfig();
    $alipayNotify = new AlipayNotify($alipay_config);
    $verify_result = $alipayNotify->verifyReturn();
    if($verify_result) {//验证成功
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //请在这里加上商户的业务逻辑程序代码

        //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
        //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

        //商户订单号

        $out_trade_no = $_GET['out_trade_no'];

        //支付宝交易号

        $trade_no = $_GET['trade_no'];

        //交易状态
        $trade_status = $_GET['trade_status'];

        //自定义逻辑代码start
        $user_id = Yii::$app->user->id;

        $model = new RechargeRecord();
        $model->number = intval($_GET['total_fee']);
        $model->order_number = $out_trade_no;
        $model->alipay_order = $trade_no;
        $model->type = $_GET['subject'];
     /*   $model->buyer_email = $_ GET['buyer_email'];;
        $model->buyer_id = $_GET['buyer_id'];*/

        if(substr($out_trade_no,0,1)==2){

            $body_data = $_GET['body'];
            $body_arr = explode(',',$body_data);

            $giveaway = intval($body_arr[0]);
            $total = intval($model->number+$giveaway);
            $model->subject = 1;
            $model->giveaway = $giveaway;

            if($model->save()){
                Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin = jiecao_coin+$total where user_id=$body_arr[1]")->execute();
                echo "<script language='javascript'>";
                echo "document.location='http://13loveme.com/member/user'";
                echo "</script>";
                exit();
            }else{

                $open=fopen("log.txt","a" );
                fwrite($open,json_encode($model->errors));
                fclose($open);
            }

        }elseif(substr($out_trade_no,0,1)==3){

            $body_u = $_GET['body'];
            $body_a = explode(',',$body_u);

            $model->subject = 2;
            $type = intval($body_a[0]);
            if($model->save()){
                Yii::$app->db->createCommand("update {{%user}} set groupid = $type where id=$body_a[1]")->execute();
                echo "<script language='javascript'>";
                echo "document.location='http://13loveme.com/member/user'";
                echo "</script>";
                exit();
            }else{
                $open=fopen("log.txt","a" );
                fwrite($open,json_encode($model->errors));
                fclose($open);
            }

        }elseif(substr($out_trade_no,0,1)==5){

            $model->subject = 5;
            $body = $_GET['body'];
            $data = explode(',',$body);
            $sort = $data[0];
            $area = $data[1];
            $recharge = $data[2];
            $type = $data[3];
            $cellphone = $data[4];
            $flag = $data[5];
            if($model->save()){
                $get_cookie = Yii::$app->request->cookies;
                $autoJoinRecord = new \frontend\modules\member\models\AutoJoinRecord();
                $autoJoinRecord->cellphone = $cellphone;
                $autoJoinRecord->member_sort = $sort;
                $autoJoinRecord->member_area = $area;
                $autoJoinRecord->recharge_type = $recharge;
                $autoJoinRecord->extra = $get_cookie->getValue('cookie_member_extra');
                $autoJoinRecord->origin = $flag;
                $autoJoinRecord->price = intval($_GET['total_fee']);
                if($autoJoinRecord->save()){

                    $autoJoinFilesText = new \frontend\models\CollectingFilesText();
                    $autoJoinFilesText->link_flag = $get_cookie->getValue('auto_join_13pt');
                    $autoJoinFilesText->flag = 'auto_a_'.$cellphone.mt_rand(1000,9999);
                    $autoJoinFilesText->save();
                    $url = "http://13loveme.com/files/";
                    Header("Location: $url$autoJoinFilesText->flag");
                    exit;

                }else{

                    $open=fopen("log.txt","a" );
                    fwrite($open,json_encode($model->errors));
                    fclose($open);
                }

            }else{

                $open=fopen("log.txt","a" );
                fwrite($open,json_encode($model->errors));
                fclose($open);
            }

        }
        //自定义逻辑代码end


        if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
            //判断该笔订单是否在商户网站中已经做过处理
            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
            //如果有做过处理，不执行商户的业务程序

        }
        else {
            echo "trade_status=".$_GET['trade_status'];
        }

        echo "验证成功<br />";

        //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    }
    else {
        //验证失败
        //如要调试，请看alipay_notify.php页面的verifyReturn函数
        echo "验证失败";
    }
    ?>
    <title>支付宝即时到账交易接口</title>
</head>
<body>
</body>
</html>