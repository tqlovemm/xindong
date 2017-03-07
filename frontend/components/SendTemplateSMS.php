<?php
namespace app\components;

class SendTemplateSMS{

    /**
     * @param $to
     * @param $datas
     * @param $tempId
     */

    static function send($to,$datas,$tempId)
    {

        //主帐号,对应开官网发者主账号下的 ACCOUNT SID
         $accountSid= '8a48b551511a2cec015123516a821c33';
        //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
         $accountToken= '3a501479966844719dcd4943cff2448c';
        //应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
        //在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
         $appId='aaf98f89511a246a01512354c5101bfd';
        //请求地址
        //沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
        //生产环境（用户应用上线使用）：app.cloopen.com
         $serverIP='app.cloopen.com';
        //请求端口，生产环境和沙盒环境一致
         $serverPort='8883';
        //REST版本号，在官网文档REST介绍中获得。
         $softVersion='2013-12-26';
        // 初始化REST SDK
        //global $accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion;
        $rest = new CCPRestSmsSDK($serverIP,$serverPort,$softVersion);
        $rest->setAccount($accountSid,$accountToken);
        $rest->setAppId($appId);

        // 发送模板短信

        $result = $rest->sendTemplateSMS($to,$datas,$tempId);
        if($result == NULL ) {
            echo "result error!";
            return;
        }
        //if($result->statusCode!=0) {

            //$data = array('error_code'=>$result->statusCode,'error_msg'=>$result->statusMsg);
            //TODO 添加错误处理逻辑
        //}else{
            // 获取返回信息
            //$smsmessage = $result->TemplateSMS;
            //$data = array('error_code'=>'success','dateCreated'=>$smsmessage->dateCreated,'smsMessageSid'=>$smsmessage->smsMessageSid);
            //TODO 添加成功处理逻辑

        //}
        return $result;

    }

}




//Demo调用 
		//**************************************举例说明***********************************************************************
		//*假设您用测试Demo的APP ID，则需使用默认模板ID 1，发送手机号是13800000000，传入参数为6532和5，则调用方式为           *
		//*result = sendTemplateSMS("13800000000" ,array('6532','5'),"1");																		  *
		//*则13800000000手机号收到的短信内容是：【云通讯】您使用的是云通讯短信模板，您的验证码是6532，请于5分钟内正确输入     *
		//*********************************************************************************************************************
//sendTemplateSMS("",array('',''),"");//手机号码，替换内容数组，模板ID
?>
