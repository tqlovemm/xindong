<?php
namespace shiyang\alipaywap;

/* *
 * 功能：纯担保交易接口接入页
 * 版本：3.3
 * 修改日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 * ************************注意*************************
 * 如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
 * 1、商户服务中心（https://b.alipay.com/support/helperApply.htm?action=consultationApply），提交申请集成协助，我们会有专业的技术工程师主动联系您协助解决
 * 2、商户帮助中心（http://help.alipay.com/support/232511-16307/0-16307.htm?sh=Y&info_type=9）
 * 3、支付宝论坛（http://club.alipay.com/read-htm-tid-8681712.html）
 * 如果不想使用扩展功能请把扩展功能参数赋空值。
 */

//require_once("alipay.config.php");

/* * ************************请求参数************************* */
use shiyang\alipaywap\lib\AlipaySubmit;
class Alipay {

//支付类型
    public $payment_type = "1";
//必填，不能修改
//服务器异步通知页面路径
    //public $notify_url = \Yii::$app->params['notifyUrl'];
//需http://格式的完整路径，不能加?id=123这类自定义参数
//页面跳转同步通知页面路径
    //public $return_url = \Yii::$app->params['returnUrl'];
//需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
//必填
//商品数量
    public $quantity = "1";
//必填，建议默认为1，不改变值，把一次交易看成是一次下订单而非购买一件商品
//物流费用
    public $logistics_fee = "0.00";
//必填，即运费
//物流类型
    public $logistics_type = "EXPRESS";
//必填，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
//物流支付方式
    public $logistics_payment = "SELLER_PAY";
//必填，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）
//订单描述
//商户订单号


    public $parameter = [];
    public $alipay_config = [];

    public function __construct($trade_no,$trade_name,$trade_price,$show_urls,$trade_introduce='') {

        /**************************请求参数**************************/

        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = $trade_no;

        //订单名称，必填
        $subject = $trade_name;

        //付款金额，必填
        $total_fee = $trade_price;

        //收银台页面上，商品展示的超链接，必填
        $show_url = $show_urls;

        //商品描述，可空
        $body = $trade_introduce;



        /************************************************************/
        $alipay_config=(new AlipayConfig)->getConfig();
//构造要请求的参数数组，无需改动
        $parameter = array(
            "service"       => $alipay_config['service'],
            "partner"       => $alipay_config['partner'],
            "seller_id"  => $alipay_config['seller_id'],
            "payment_type"	=> $alipay_config['payment_type'],
            "notify_url"	=> $alipay_config['notify_url'],
            "return_url"	=> $alipay_config['return_url'],
            "_input_charset"	=> trim(strtolower($alipay_config['input_charset'])),
            "out_trade_no"	=> $out_trade_no,
            "subject"	=> $subject,
            "total_fee"	=> $total_fee,
            "show_url"	=> $show_url,
            "body"	=> $body,
            //其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.2Z6TSk&treeId=60&articleId=103693&docType=1
            //如"参数名"	=> "参数值"   注：上一个参数末尾需要“,”逗号。

        );

//建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;

    }


}

//建立请求
/*$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($this->parameter, "get", "确认");
echo $html_text;*/



