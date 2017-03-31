<?php
namespace yii\myhelper;


class Easemob
{
    private $host = 'https://a1.easemob.com';
    private $client_id ;
    private $client_secret;
    private $org_name;
    private $app_name ;
    private $token='';
    /*
     * ------------------------
     * 公共方法             开始
     * ------------------------
     */
    /**
     * 初始化参数
     *
     * @param array $options
     * @param $options['client_id']
     * @param $options['client_secret']
     * @param $options['org_name']
     * @param $options['app_name']
     */
    public function __construct($options) {
        $this->client_id =  $options ['client_id'];
        $this->client_secret = $options ['client_secret'] ;
        $this->org_name =  $options ['org_name'] ;
        $this->app_name =  $options ['app_name'] ;
    }

    /**
     * 模拟POST与GET请求
     *
     * Examples:
     * ```
     * HttpCurl::request('http://example.com/', 'post', array(
     *  'user_uid' => 'root',
     *  'user_pwd' => '123456'
     * ));
     *
     * HttpCurl::request('http://example.com/', 'post', '{"name": "peter"}');
     *
     * HttpCurl::request('http://example.com/', 'post', array(
     *  'file1' => '@/data/sky.jpg',
     *  'file2' => '@/data/bird.jpg'
     * ));
     *
     * // windows
     * HttpCurl::request('http://example.com/', 'post', array(
     *  'file1' => '@G:\wamp\www\data\1.jpg',
     *  'file2' => '@G:\wamp\www\data\2.jpg'
     * ));
     *
     * HttpCurl::request('http://example.com/', 'get');
     *
     * HttpCurl::request('http://example.com/?a=123', 'get', array('b'=>456));
     * ```
     *
     * @param string $url [请求地址]
     * @param string $type [请求方式 post or get]
     * @param bool|string|array $data [传递的参数]
     * @param array $header [可选：请求头] eg: ['Content-Type:application/json']
     * @param int $timeout [可选：超时时间]
     *
     * @return array($body, $header, $status, $errno, $error)
     * - $body string [响应正文]
     * - $header string [响应头]
     * - $status array [响应状态]
     * - $errno int [错误码]
     * - $error string [错误描述]
     */

    protected function myRequest($url, $type, $data = false, $header = [], $timeout = 0)
    {
        $cl = curl_init();
        // 兼容HTTPS
        if (stripos($url, 'https://') !== FALSE) {
            curl_setopt($cl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($cl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($cl, CURLOPT_SSLVERSION, 1);
        }
        // 设置返回内容做变量存储
        curl_setopt($cl, CURLOPT_RETURNTRANSFER, 1);
        // 设置需要返回Header
        curl_setopt($cl, CURLOPT_HEADER, true);
        // 设置请求头
        if (count($header) > 0) {
            curl_setopt($cl, CURLOPT_HTTPHEADER, $header);
        }
        // 设置需要返回Body
        curl_setopt($cl, CURLOPT_NOBODY, 0);
        // 设置超时时间
        if ($timeout > 0) {
            curl_setopt($cl, CURLOPT_TIMEOUT, $timeout);
        }
        // POST/GET参数处理
        $type = strtoupper($type);
        if ($type == 'POST') {
            curl_setopt($cl, CURLOPT_POST, true);
            // convert @ prefixed file names to CurlFile class
            // since @ prefix is deprecated as of PHP 5.6
            if (class_exists('\CURLFile') && is_array($data)) {
                foreach ($data as $k => $v) {
                    if (is_string($v) && strpos($v, '@') === 0) {
                        $v = ltrim($v, '@');
                        $data[$k] = new \CURLFile($v);
                    }
                }
            }
            curl_setopt($cl, CURLOPT_POSTFIELDS, $data);
        }
        if ($type == 'GET' && is_array($data)) {
            if (stripos($url, "?") === FALSE) {
                $url .= '?';
            }
            $url .= http_build_query($data);
        }
        curl_setopt($cl, CURLOPT_URL, $url);
        // 读取获取内容
        $response = curl_exec($cl);
        // 读取状态
        $status = curl_getinfo($cl);
        // 读取错误号
        $errno  = curl_errno($cl);
        // 读取错误详情
        $error = curl_error($cl);
        // 关闭Curl
        curl_close($cl);
        if ($errno == 0 && isset($status['http_code'])) {
            //$header = substr($response, 0, $status['header_size']);
            $body = substr($response, $status['header_size']);
            //return array($body, $header, $status, 0, '');
            return array(json_decode($body));
        } else {
            return array('', '', $status, $errno, $error);
        }
    }

    private function request($api_name, $data, $method='POST',$header = [])
    {

        if(isset($data)){
            $data_string = json_encode($data);
        }
        $ch = curl_init($this->host . "/$this->org_name/$this->app_name/".$api_name);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if(strtoupper($method)!='GET'){

            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
        }

        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE ); // 对认证证书来源的检查
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE ); // 从证书中检查SSL加密算法是否存在
        curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)' ); // 模拟用户使用的浏览器

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        if(count($header)>0){

            curl_setopt($ch,CURLOPT_HTTPHEADER,$header);

        }else{
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                //'Accept: application/json',
                'Authorization: Bearer '.$this->getToken()
                // 'Content-Length: ' . strlen($data_string)
            )   );
        }

        $result = curl_exec($ch);
        $result =  json_decode($result, true);
        curl_close($ch);
        return $result;
    }

    /*
     * 取得TOKEN
     */
    public function getToken($reGet=false)
    {
        if(!$this->token || $reGet == true){
            $path = "/$this->org_name/$this->app_name/token";
            $data = array(
                'grant_type' => 'client_credentials',
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret
            );
            $data_string = json_encode($data);

            $ch = curl_init($this->host . $path);
            curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt ($ch, CURLOPT_POSTFIELDS,$data_string);
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE ); // 对认证证书来源的检查
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE ); // 从证书中检查SSL加密算法是否存在
            curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)' ); // 模拟用户使用的浏览器
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt ($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json'));
            $result = curl_exec($ch);
            $result_arr = json_decode($result, true);
            if(isset($result_arr['error'])){
                echo $result;exit;
            }else{
                $this->token = $result_arr['access_token'];
            }
            return $this->token;
        }else{
            return $this->token;
        }
    }
    /*
     * ------------------------
     * 公共方法             结束
     * ------------------------
     */

    /*
     * ------------------------------------
     * 群组方法             开始
     * ------------------------------------
     */
    /*
     * 获取app中所有的群组
     */
    public function getGroupList()
    {
        $result =  $this->request('chatgroups', '','GET');
        return $result;
    }
    /*
    * 获取一个或者多个群组的详情
    * $groupList mix  String or Array
    *  demo: $groupList = array('1423734662380237', '1423734662380238)
    */
    public function getGroupDetial($groupList)
    {

        if(gettype($groupList) == 'array'){
            $group_list = implode(',', $groupList);
        }else{
            $group_list = $groupList;
        }

        $result =  $this->request('chatgroups'.'/'.$group_list, '','GET');
        return $result;
    }
    /*
     *
     * $groupInfo Array 群信息参数如下;
    "groupname":"testrestgrp12", //群组名称, 此属性为必须的
    "desc":"server create group", //群组描述, 此属性为必须的
    "public":true, //是否是公开群, 此属性为必须的
    "maxusers":300, //群组成员最大数(包括群主), 值为数值类型,默认值200,此属性为可选的
    "approval":true, //加入公开群是否需要批准, 没有这个属性的话默认是true（不需要群主批准，直接加入）, 此属性为可选的
    "owner":"jma1", //群组的管理员, 此属性为必须的
    "members":["jma2","jma3"] //群组成员,此属性为可选的,但是如果加了此项,数组元素至少一个（注：群主jma1不需要写入到members里面）
     * demo:
    * $groupInfo = array(
                'groupname' => 'leee',
                'desc'       => 'leeff',
                'owner' => 'sy1'
    );
     */
    public function createGroup($groupInfo)
    {
        $groupInfo['public'] = isset($groupInfo['public']) ? $groupInfo['public'] : true;       //默认公开
        $groupInfo['approval'] = isset($groupInfo['approval']) ? $groupInfo['maxusers'] : false;//默认需要审核

        $result =  $this->request('chatgroups', $groupInfo, 'POST');
        return $result;
    }
    public function addUser($data){

        $result =  $this->request('users',$data,'POST');

        return $result;

    }
    public function updateUser($username,$password,$userInfo)
    {
        $result =  $this->request('users'.'/'.$username.'/'.$password, $userInfo ,'PUT');
        return $result;
    }

    /*
     * 更新群组信息
     * @param $groupId int 群组id  必填
     * $param $groupInfo array 群组信息 必填
     * 参数说明：
     * $groupInfo = array( "groupname":"testrestgrp12", //群组名称 可选
        "description":"update groupinfo", //群组描述 可选
        "maxusers":300, //群组成员最大数(包括群主), 值为数值类型 可选
      )
     */

    public function updateGroup($groupId, $groupInfo=array())
    {
        $result =  $this->request('chatgroups'.'/'.$groupId, $groupInfo ,'PUT');
        return $result;
    }
    /*
     * 群组删除
     * @param $groupId 必填 群组ID Stirng
     */
    public function deleteGroup($groupId){
        $result = $this->request('chatgroups'.'/'.$groupId,'', 'DELETE');
        return $result;
    }
    /*
    * 获取群组用户
    * @param $groupId 必填 群组ID Stirng
    */
    public function getGroupUsers($groupId){
        $result = $this->request('chatgroups/'.$groupId.'/users','', 'GET');
        return $result;
    }

    /*
     * 查看好友
     * @param $owner_username 必填     用户名
     */
    public function findFriend($owner_username)
    {
        $result = $this->request('users/'.$owner_username.'/contacts/users','', 'GET');
        return $result;
    }

    /*
     * 添加好友
     * @param $owner_username 必填     用户名
     * @param $friend_username 必填    好友名
     */
    public function addFriend($owner_username, $friend_username)
    {

        $result = $this->request('users/'.$owner_username.'/contacts/users/'.$friend_username,'', 'POST');
        return $result;
    }

    /*
     * 删除好友
     * @param $owner_username 必填     用户名
     * @param $friend_username 必填    好友名
     */
    public function delFriend($owner_username, $friend_username)
    {

        $result = $this->request('users/'.$owner_username.'/contacts/users/'.$friend_username,'', 'DELETE');
        return $result;
    }

    /*
     * 群组批量加人
     * @param $groupId 必填 群组ID Stirng
     * @param $users 必填    用户名  mix(String,array)
     */
    public function addGroupUsers($groupId, $users)
    {
        if(gettype($users) != 'array'){
            $users[] = $users;
        }
        $data['usernames'] = $users;
        $result = $this->request('chatgroups'.'/'.$groupId.'/users', $data, 'POST');
        return $result;
    }

    /*
     * 群组减人：从群中移除某个成员。
     * @param $groupId 群组id 必填 String
     * @param $user 用户名 必填 String
     */
    public function deleteGroupUser($groupId, $user)
    {
        $result = $this->request('chatgroups'.'/'.$groupId.'/users/'.$user, '', 'DELETE');
        return $result;
    }
    /*
     * 获取一个用户参与的所有群组
     * $user String 用户名 必填
     */
    public function getUserGroups($user){
        $result = $this->request('users/'.$user.'/joined_chatgroups', '', 'GET');
        return $result;
    }

    /*
     * 发送文本消息
     *
     */
    function sendText($data){

        $result = $this->request('messages/',$data,'POST');
        return $result;
    }

    /*
     * 发送图片
     *
     */
    function sendImage($data){

        $result = $this->request('messages/',$data,'POST');
        return $result;
    }

    /*
     * 发送上传文件
     *
     */
    function uploadFile($filePath){

        $url = $this->host."/$this->org_name/$this->app_name/".'chatfiles/';
        $data = array('file'=>'@'.$filePath);
        $header = array('enctype:multipart/form-data',"Authorization: Bearer ".$this->getToken(),"restrict-access:true");
        $result = $this->myRequest($url,"POST",$data,$header);
        return $result;
    }

    public function disconnect($username){
        $url = $this->host."/$this->org_name/$this->app_name/users/{$username}/disconnect";
        $header = array("Content-Type:application/json","Authorization: Bearer ".$this->getToken());
        $result = $this->myRequest($url,"GET",false,$header);
        return $result;
    }

    /*
     * ------------------------------------
     * 群组方法             结束
     * ------------------------------------
     */
}