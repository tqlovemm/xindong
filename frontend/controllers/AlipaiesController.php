<?php
namespace frontend\controllers;
use app\components\SaveToLog;
use backend\modules\bgadmin\models\BgadminMember;
use backend\modules\exciting\models\OtherTextPic;
use backend\modules\flop\models\FlopContent;
use backend\modules\good\models\WeichatVoteImg;
use backend\modules\weekly\models\Weekly;
use frontend\models\CollectingFilesImg;
use frontend\models\CollectingFilesText;
use frontend\models\CollectingSeventeenFilesImg;
use frontend\modules\member\models\AlipayCoinRechargeRecord;
use frontend\modules\member\models\HomePhoto;
use frontend\modules\member\models\UserVipTempAdjust;
use frontend\modules\test\models\WeichatDazzleImg;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\web\Controller;
use Yii;
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
class AlipaiesController extends Controller
{
    public function actionNotifyUrl(){

    /* *
     * 功能：支付宝服务器异步通知页面
     * 版本：3.3
     * 日期：2012-07-23
     * 说明：
     * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
     * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。


     *************************页面功能说明*************************
     * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
     * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
     * 该页面调试工具请使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
     * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
     */

//计算得出通知验证结果
        $alipay_config = (new AlipayConfig())->getConfig();
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();

        if($verify_result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代

            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

            //商户订单号

            $out_trade_no = $_POST['out_trade_no'];

            //支付宝交易号

            $trade_no = $_POST['trade_no'];

            //交易状态
            $trade_status = $_POST['trade_status'];

            $open=fopen("log.txt","a" );
            fwrite($open,json_encode($_POST));
            fclose($open);
            if($_POST['trade_status'] == 'TRADE_FINISHED') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
            else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //付款完成后，支付宝系统发送该交易状态通知

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            echo "success";		//请不要修改或删除

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            echo "fail";

            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }

    }

    public function actionReturnUrl(){

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

            $trade_body = json_decode($_GET['body'],true);

            $model = new AlipayCoinRechargeRecord();
            $model->total_fee = $_GET['total_fee'];
            $model->out_trade_no = $out_trade_no;
            $model->subject = $_GET['subject'];
            $model->user_id = $trade_body['user_id'];
            $model->giveaway = $trade_body['giveaway'];
            $model->user_number = $trade_body['user_number'];
            $model->notify_time = $_GET['notify_time'];
            $model->type = $trade_body['type'];
            $model->extra = json_encode($_GET);
            $model->description = $trade_body['description'];
            if($trade_body['groupid']==2){
                $vip_text = "普通会员";
            }elseif($trade_body['groupid']==3){
                $vip_text = "高端会员";
            }elseif($trade_body['groupid']==4){
                $vip_text = "至尊会员";
            }elseif($trade_body['groupid']==5){
                $vip_text = "私人定制";
            }elseif($trade_body['groupid']==1){
                $vip_text = "网站会员";
            }else{
                $vip_text = "未知会员";
            }
            if($trade_body['type']==1){

                $total = intval($_GET['total_fee']+$trade_body['giveaway']);

                if($model->save()){
                    try{
                        \common\components\SaveToLog::userBgRecord("支付宝充值节操币{$_GET['total_fee']},赠送节操币{$trade_body['giveaway']}",$trade_body['user_id']);
                    }catch (Exception $e){
                        throw new ErrorException($e->getMessage());
                    }
                    Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin = jiecao_coin+$total where user_id={$trade_body['user_id']}")->execute();
                    echo "<script language='javascript'>";
                    echo "document.location='http://13loveme.com/member/user'";
                    echo "</script>";
                    exit();
                }else{
                    $open=fopen("log.txt","a" );
                    fwrite($open,json_encode($model->errors));
                    fclose($open);
                }

            }elseif($trade_body['type']==2){

                if($model->save()){
                    Yii::$app->db->createCommand("update {{%user}} set groupid = {$trade_body['groupid']} where id={$trade_body['user_id']}")->execute();
                    Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin = jiecao_coin+($_GET[total_fee]/2.5) where user_id={$trade_body['user_id']}")->execute();
                    try{
                        \common\components\SaveToLog::userBgRecord("支付宝升级为{$vip_text},赠送节操币".$_GET['total_fee']/2.5,$trade_body['user_id']);
                    }catch (Exception $e){
                        throw new ErrorException($e->getMessage());
                    }

                    echo "<script language='javascript'>";
                    echo "document.location='http://13loveme.com/member/user'";
                    echo "</script>";
                    exit();
                }else{
                    $open=fopen("log.txt","a" );
                    fwrite($open,json_encode($model->errors));
                    fclose($open);
                }

            }elseif($trade_body['type']==3){

                if($model->save()){

                    $vipAdjust = new UserVipTempAdjust();
                    $vipAdjust->user_id = $trade_body['user_id'];
                    $vipAdjust->vip = $trade_body['groupid'];
                    $vipAdjust->save();

                    Yii::$app->db->createCommand("update {{%user}} set groupid = {$trade_body['groupid']} where id={$trade_body['user_id']}")->execute();
                    Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin = jiecao_coin+($_GET[total_fee]/2.5) where user_id={$trade_body['user_id']}")->execute();

                    try{
                        \common\components\SaveToLog::userBgRecord("支付宝升级为试用{$vip_text},赠送节操币".$_GET['total_fee']/2.5,$trade_body['user_id']);
                    }catch (Exception $e){
                        throw new ErrorException($e->getMessage());
                    }

                    echo "<script language='javascript'>";
                    echo "document.location='http://13loveme.com/member/user'";
                    echo "</script>";
                    exit();
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
        } else {
            //验证失败
            //如要调试，请看alipay_notify.php页面的verifyReturn函数
            echo "验证失败";
        }

    }

    public function actionRotate($id,$direction){
        // File and rotation
        $img = CollectingFilesImg::find()->where(['id'=>$id])->asArray()->one();

        $this->imgturn(str_replace('/uploads','uploads',$img['thumb_img']),$direction);
        $this->imgturn(str_replace('/uploads','uploads',$img['img']),$direction);
        echo $_GET['callbackparam']."(".json_encode($img['thumb_img']).")";

    }
    public function actionRotateSeventeen($id,$direction){
        // File and rotation
        $img = CollectingSeventeenFilesImg::find()->where(['id'=>$id])->asArray()->one();

        $this->imgturn(str_replace('/uploads','uploads',$img['img']),$direction);
        echo $_GET['callbackparam']."(".json_encode($img['img']).")";

    }

    public function actionRotateVoteImg($id,$direction){

        $img = WeichatVoteImg::find()->where(['id'=>$id])->asArray()->one();
        $path = explode('http://13loveme.com:82/',$img['path']);
        $thumb = explode('http://13loveme.com:82/',$img['thumb']);

        if(count($path)<2){
            $path = explode('http://13loveme.com/',$img['path']);
            $thumb = explode('http://13loveme.com/',$img['thumb']);
            $this->imgturn(Yii::getAlias('@frontend/web/').$path[1],$direction);
            $this->imgturn(Yii::getAlias('@frontend/web/').$thumb[1],$direction);
        }else{
            $this->imgturn(Yii::getAlias('@backend/web/').$path[1],$direction);
            $this->imgturn(Yii::getAlias('@backend/web/').$thumb[1],$direction);
        }


        $thumb[1] = json_encode(Yii::getAlias('@backend/web/').$thumb[1]);
        echo $_GET['callbackparam']."(".$thumb[1].")";
    }

    public function actionRotateAbdImg($id,$direction){

        $img = WeichatDazzleImg::find()->where(['id'=>$id])->asArray()->one();
        $path = explode('http://13loveme.com:82/',$img['path']);
        $thumb = explode('http://13loveme.com:82/',$img['thumb']);

        if(count($path)<2){
            $path = explode('http://13loveme.com/',$img['path']);
            $thumb = explode('http://13loveme.com/',$img['thumb']);
            $this->imgturn(Yii::getAlias('@frontend/web/').$path[1],$direction);
            $this->imgturn(Yii::getAlias('@frontend/web/').$thumb[1],$direction);
        }else{
            $this->imgturn(Yii::getAlias('@backend/web/').$path[1],$direction);
            $this->imgturn(Yii::getAlias('@backend/web/').$thumb[1],$direction);
        }


        $thumb[1] = json_encode(Yii::getAlias('@backend/web/').$thumb[1]);
        echo $_GET['callbackparam']."(".$thumb[1].")";
    }

    function imgturn($src,$direction=1)
    {
        //$ext = pathinfo($src)['extension'];
        $ename=getimagesize($src);
        $ename=explode('/',$ename['mime']);
        $ext=$ename[1];
        switch ($ext) {
            case 'gif':
                $img = imagecreatefromgif($src);
                break;
            case 'jpg':
            case 'jpeg':
                $img = imagecreatefromjpeg($src);
                break;
            case 'png':
                $img = imagecreatefrompng($src);
                break;
            default:
                die('图片格式错误!');
                break;
        }
        $width = imagesx($img);
        $height = imagesy($img);
        $img2 = imagecreatetruecolor($height,$width);
        //顺时针旋转90度
        if($direction==1)
        {
            for ($x = 0; $x < $width; $x++) {
                for($y=0;$y<$height;$y++) {
                    imagecopy($img2, $img, $height-1-$y,$x, $x, $y, 1, 1);
                }
            }
        }else if($direction==2) {
            //逆时针旋转90度
            for ($x = 0; $x < $height; $x++) {
                for($y=0;$y<$width;$y++) {
                    imagecopy($img2, $img, $x, $y, $width-1-$y, $x, 1, 1);
                }
            }
        }
        switch ($ext) {
            case 'jpg':
            case "jpeg":
                imagejpeg($img2, $src, 100);
                break;
            case "png":
                imagepng($img2, $src, 100);
                break;

            default:
                die('图片格式错误!');
                break;
        }
        imagedestroy($img);
        imagedestroy($img2);
    }
    public function actionSet(){

        $redis = Yii::$app->redis;
        //$redis->slaveof('47.90.23.171',6379);//切换到从实例
        //$redis->slaveof('182.254.217.147',6381);
        // $redis->slaveof('no','one');//切换回到主实例

        $redis->hmset('data:01','name','tqlmm','sex','0');

    }

    public function actionGet($id){
        $redis = Yii::$app->redis;
        echo '<pre>';
        var_dump($redis->hvals('data:01'));
    }

    public function actionSmTeach(){
        return $this->render('sm-teach');

    }

    public function actionMs(){
        $result = '';
        $insert = new BgadminMember();
        foreach (FlopContent::find()->asArray()->each(10) as $list) {
            $query = $insert::findOne(['number'=>$list['number']]);
            if(empty($query)){
                $insert->number = $list['number'];
                $insert->weicaht = '翻牌导入暂无';
                $insert->weibo = '翻牌导入暂无';
                $insert->cellphone = '翻牌导入暂无';
                $insert->address_a = $list['area'];
                $insert->sex = 0;
                $insert->vip = 2;
                $insert->time = date('Y-m-d',time());
                if(!$insert->save()){
                    SaveToLog::log($insert->errors,'flop.log');
                }
                $result = "同步一条数据";
            }else{
                $result = "没有数据啦亲，别刷我了";
            }
        }
        return $this->render('ms',['result'=>$result]);
    }
    public function actionMst(){
        $result = '';
        $insert = new OtherTextPic();
        foreach (HomePhoto::find()->where(['album_id'=>1020])->asArray()->each(10) as $list) {
            $query = $insert::findOne(['pic_path'=>'http://13loveme.com'.$list['path']]);
            if(empty($query)){
                $insert->tid = 3;
                $insert->name = '心动后援';
                $insert->content = '心动后援';
                $insert->pic_path = 'http://13loveme.com'.$list['path'];
                $insert->type = 2;
                if(!$insert->save()){
                    SaveToLog::log($insert->errors,'flop.log');
                }
                $result = "同步一条数据";
            }else{
                $result = "没有数据啦亲，别刷我了";
            }
        }
        return $this->render('mst',['result'=>$result]);
    }

    public function actionD(){
        $result = '';
        $insert = new BgadminMember();
        foreach (CollectingFilesText::find()->where(['status'=>2])->asArray()->each(10) as $list) {
            $query = $insert::findOne(['number'=>$list['id']]);
            if(empty($query)){
                $insert->number = $list['id'];
                $insert->weicaht = $list['weichat'];
                $insert->weibo = $list['weibo'];
                $insert->cellphone = $list['cellphone'];
                $insert->address_a = $list['address'];
                $insert->address_b = $list['often_go'];
                $insert->sex = 0;
                $insert->vip = 2;
                $insert->time = date('Y-m-d',time());
                if(!$insert->save()){
                    SaveToLog::log($insert->errors,'follow.log');
                }
                $result = "同步一条数据";
            }else{
                $result = "没有数据啦亲，别刷我了";
            }
        }
        return $this->render('d',['result'=>$result]);
    }
    public function actionS1(){

        return $this->render('s1');
    }

    public function actionCd(){

        $dir = 'uploads/collecting/thumb';
        $dir1 = 'uploads/collecting';
        $efiles = scandir($dir);
        $efiles1 = scandir($dir1);
        $ex = array_diff($efiles1,$efiles);
        unset($ex[count($ex)-1]);

        foreach ($ex as $im) {
            $imgs = 'uploads/collecting/'.$im;
            $filename = pathinfo($imgs)["filename"];
            $info = filesize($imgs) / 1024 / 1024;
            if($info>0.2){
                if(!in_array($filename,$efiles)){
                    $extension = pathinfo($imgs)["extension"];
                    $filename = pathinfo($imgs)["filename"];
                    if (in_array($extension, ['png'])) {
                        $im = imagecreatefrompng($imgs);
                    } elseif (in_array($extension, ['jpg', 'jpeg'])) {
                        try {
                            $im = imagecreatefromjpeg($imgs);//参数是图片的存方路径
                        } catch (\Exception $e) {
                            print $e->getMessage();
                        }
                    } else {
                        $im = imagecreatefromgif($imgs);
                    }//参数是图片的存方路径}
                    $maxwidth = "1280";//设置图片的最大宽度
                    $maxheight = "1280";//设置图片的最大高度
                    $name = "uploads/collecting/thumb/$filename";//图片的名称，随便取吧
                    $filetype = ".$extension";//图片类型
                    $this->resizeImage($im, $maxwidth, $maxheight, $name, $filetype);//调用上面的函数
                }
            }else{
                if(!in_array($filename,$efiles)){
                    copy($imgs,'uploads/collecting/thumb/'.$im);
                }
            }
        }
    }
    public function actionCdd(){

        $im = '';
        $imgs = '13639_14715107766881.jpg';
        $info = filesize($imgs) / 1024 / 1024;
        if($info>0.2){
            $extension = pathinfo($imgs)["extension"];
            $filename = pathinfo($imgs)["filename"];
            if (in_array($extension, ['png'])) {
                $im = imagecreatefrompng($imgs);
            } elseif (in_array($extension, ['jpg', 'jpeg'])) {
                try {
                    $im = imagecreatefromjpeg($imgs);//参数是图片的存方路径
                } catch (\Exception $e) {
                    print $e->getMessage();
                }
            } else {
                $im = imagecreatefromgif($imgs);
            }//参数是图片的存方路径}
            $maxwidth = "1280";//设置图片的最大宽度
            $maxheight = "1280";//设置图片的最大高度
            $name = "uploads/collecting/thumb/$filename";//图片的名称，随便取吧
            $filetype = ".$extension";//图片类型
            $this->resizeImage($im, $maxwidth, $maxheight, $name, $filetype);//调用上面的函数
        }
    }

    function resizeImage($im,$maxwidth,$maxheight,$name,$filetype)
    {

        $pic_width = imagesx($im);
        $pic_height = imagesy($im);
        $widthratio = $heightratio = $resizeheight_tag = $resizewidth_tag = $ratio = false;

        if(($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight))
        {
            if($maxwidth && $pic_width>$maxwidth)
            {
                $widthratio = $maxwidth/$pic_width;
                $resizewidth_tag = true;
            }

            if($maxheight && $pic_height>$maxheight)
            {
                $heightratio = $maxheight/$pic_height;
                $resizeheight_tag = true;
            }

            if($resizewidth_tag && $resizeheight_tag)
            {
                if($widthratio<$heightratio)
                    $ratio = $widthratio;
                else
                    $ratio = $heightratio;
            }

            if($resizewidth_tag && !$resizeheight_tag)
                $ratio = $widthratio;
            if($resizeheight_tag && !$resizewidth_tag)
                $ratio = $heightratio;

            $newwidth = $pic_width * $ratio;
            $newheight = $pic_height * $ratio;

            if(function_exists("imagecopyresampled"))
            {
                $newim = imagecreatetruecolor($newwidth,$newheight);//PHP系统函数
                imagecopyresampled($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);//PHP系统函数
            }
            else
            {
                $newim = imagecreate($newwidth,$newheight);
                imagecopyresized($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
            }
            $name = $name.$filetype;
            imagejpeg($newim,$name);
            imagedestroy($newim);
        }
        else
        {
            $name = $name.$filetype;
            imagejpeg($im,$name);
        }
    }

    public function dd(){

        $data = new CollectingFilesImg();
        $model = $data::find()->select('id,img,thumb_img')->asArray()->all();
        foreach ($model as $item){
            if(empty($item['thumb_img'])){
                $str = str_replace('/collecting/','/collecting/thumb/',$item['img']);
                $query = $data::findOne($item['id']);
                $query->thumb_img = $str;
                $query->update();
            }
        }
    }
    public function cx(){

        $data = new FlopContent();
        $model = $data::find()->select('id,content,path')->where(['like','path','uploads/collecting'])->asArray()->all();
        foreach ($model as $item){
            $str = str_replace('/collecting/','/collecting/thumb/',$item['path']);
            $query = $data::findOne($item['id']);
            $query->content = $str;
           $query->update();
        }

    }

    public function actionDtq(){

        $model = Weekly::find()->select('number')->where(['status'=>2])->asArray()->column();
        $query = BgadminMember::find()->select('number')->where(['sex'=>1])->asArray()->column();

        $m = array_diff($model,$query);
        return var_dump(array_unique($m));

    }
    public function getddds(){

        $model = Weekly::find()->select('number')->where(['status'=>2])->asArray()->column();
        return $model;
    }
    public function getdcs(){
        $query = BgadminMember::find()->select('number')->where(['sex'=>1])->asArray()->column();
        return $query;
    }

    public function actionDds(){

     /*   $number = $session->get('bg_number');
        if(empty($number)){
            $model = Weekly::find()->select('id,title,number,updated_at')->where(['status'=>2])->asArray()->one();
        }else{
            $model = Weekly::find()->select('id,title,number,updated_at')->where(['status'=>2])->where(['>','id',$number])->asArray()->one();
        }*/
        $model = Weekly::find()->where(['status'=>2])->andWhere(['not in','number',$this->getdcs()])->asArray()->one();
        $query = new BgadminMember();
        if(empty($query::findOne(['number'=>$model['number']]))){
            $query->address_a = $model['title'];
            $query->number = $model['number'];
            $query->sex = 1;
            $query->vip = 1;
            $query->coin = 1;
            $query->fantasies = 'A';
            $query->credit = 'A';
            $query->created_by = 'admin';
            $query->created_at = $model['updated_at'];
            $query->updated_at = $model['updated_at'];
            if($query->save()){
                return $this->render('dds',['query'=>$model['id'].'-'.$model['number']]);
            }else{
                return var_dump($query->errors);
            }
        }

        return var_dump($model);

    }
}