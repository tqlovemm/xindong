<?php
namespace yii\wxpay\lib;
use common\components\SaveToLog;
use frontend\modules\member\models\UserVipTempAdjust;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\db\Query;
use Yii;
use yii\web\User;

/**
 * 
 * 回调基础类
 * @author widyhu
 *
 */
class WxPayNotify extends WxPayNotifyReply
{
	/**
	 * 
	 * 回调入口
	 * @param bool $needSign  是否需要签名输出
	 */
	final public function Handle($needSign = true)
	{
		$msg = "OK";
		//当返回false的时候，表示notify中调用NotifyCallBack回调失败获取签名校验失败，此时直接回复失败
		$result = WxPayApi::notify(array($this, 'NotifyCallBack'), $msg);
		if($result == false){
			$this->SetReturn_code("FAIL");
			$this->SetReturn_msg($msg);
			$this->ReplyNotify(false);
			return;
		} else {
			//该分支在成功回调到NotifyCallBack方法，处理完成之后流程
			$this->SetReturn_code("SUCCESS");
			$this->SetReturn_msg("OK");
		}
		$this->ReplyNotify($needSign);

	}
	
	/**
	 * 
	 * 回调方法入口，子类可重写该方法
	 * 注意：
	 * 1、微信回调超时时间为2s，建议用户使用异步处理流程，确认成功之后立刻回复微信服务器
	 * 2、微信服务器在调用失败或者接到回包为非确认包的时候，会发起重试，需确保你的回调是可以重入
	 * @param array $data 回调解释出的参数
	 * @param string $msg 如果回调处理失败，可以将错误信息输出到该方法
	 * @return true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
	 */
	public function NotifyProcess($data, &$msg)
	{

		$user_id  = json_decode($data['attach'],true)['user_id'];
		$groupid  = json_decode($data['attach'],true)['groupid'];
		$type  = json_decode($data['attach'],true)['type'];
        if($groupid==2){
            $vip_text = "普通会员";
        }elseif($groupid==3){
            $vip_text = "高端会员";
        }elseif($groupid==4){
            $vip_text = "至尊会员";
        }elseif($groupid==5){
            $vip_text = "私人定制";
        }elseif($groupid==1){
            $vip_text = "网站会员";
        }else{
            $vip_text = "未知会员";
        }
		if(strtolower($data['result_code'])=='success'){

			$query = (new Query())->select("*")->from("{{%weipay_record}}")->where(['out_trade_no'=>$data['out_trade_no']])->all();

			if(empty($query)){

					if($type==1) {

						$insert = \Yii::$app->db->createCommand()->insert('{{%weipay_record}}',[

							"user_id"=>$user_id,
							"type"=>2,
							"giveaway"=>$groupid,
							"out_trade_no"=>$data['out_trade_no'],
							"total_fee"=>$data['total_fee']/100,
							"transaction_id"=>$data['transaction_id'],
							"extra"=>json_encode($data),
							"created_at"=>time(),
							"updated_at"=>time(),

						])->execute();

						if($insert) {

							$giveaway = (integer)$groupid;
							\Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin=jiecao_coin+($data[total_fee]/100)+$giveaway where user_id=$user_id")->execute();

                            try{
                                SaveToLog::userBgRecord("微信充值节操币".($data['total_fee']/100).",赠送节操币$giveaway",$user_id);
                            }catch (Exception $e){
                                throw new ErrorException($e->getMessage());
                            }
						}


					}elseif($type==2){


						$insert = \Yii::$app->db->createCommand()->insert('{{%weipay_record}}',[

							"user_id"=>$user_id,
							"type"=>3,
							"out_trade_no"=>$data['out_trade_no'],
							"total_fee"=>$data['total_fee']/100,
							"transaction_id"=>$data['transaction_id'],
							"extra"=>json_encode($data),
							"created_at"=>time(),
							"updated_at"=>time(),

						])->execute();

						if($insert){

							\Yii::$app->db->createCommand("update {{%user}} set groupid = $groupid where id=$user_id")->execute();
                            \Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin = jiecao_coin+($data[total_fee]/250) where user_id={$user_id}")->execute();


                            try{
                                SaveToLog::userBgRecord("微信升级为$vip_text，赠送节操币".$data['total_fee']/250,$user_id);
                            }catch (Exception $e){
                                throw new ErrorException($e->getMessage());
                            }
						}

					}elseif($type==3){

                        $insert = \Yii::$app->db->createCommand()->insert('{{%weipay_record}}',[

                            "user_id"=>$user_id,
                            "type"=>3,
                            "out_trade_no"=>$data['out_trade_no'],
                            "total_fee"=>$data['total_fee']/100,
                            "transaction_id"=>$data['transaction_id'],
                            "extra"=>json_encode($data),
                            "created_at"=>time(),
                            "updated_at"=>time(),

                        ])->execute();

                        if($insert){

                            $vipAdjust = new UserVipTempAdjust();
                            $vipAdjust->user_id = $user_id;
                            $vipAdjust->vip = $groupid;
                            $vipAdjust->save();

                            \Yii::$app->db->createCommand("update {{%user}} set groupid = $groupid where id=$user_id")->execute();
                            \Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin = jiecao_coin+($data[total_fee]/200) where user_id={$user_id}")->execute();

                            try{
                                SaveToLog::userBgRecord("微信升级为试用$vip_text，赠送节操币".$data['total_fee']/200,$user_id);
                            }catch (Exception $e){
                                throw new ErrorException($e->getMessage());
                            }
                        }

                    }elseif(substr($data['out_trade_no'],0,1)==4){

                        $area = json_decode($data['attach'],true)['area'];
						$insert = \Yii::$app->db->createCommand()->insert('{{%weipay_record}}',[

							"user_id"=>0,
							"type"=>4,
							"out_trade_no"=>$data['out_trade_no'],
							"total_fee"=>$data['total_fee']/100,
							"transaction_id"=>$data['transaction_id'],
							"extra"=>json_encode($data),
							"created_at"=>time(),
							"updated_at"=>time(),

						])->execute();

						if($insert){

                            $areas = array_unique(array_filter(explode(',',urldecode($area))));
                            $areamd = (new Query())->select('address_province')->from('pre_collecting_17_files_text')->where(['id'=>$areas])->column();
                            $a = implode('，',$areamd);
						    $ar = $a.'，';

							\Yii::$app->db->createCommand("update {{%collecting_17_wei_user}} set address=CONCAT(address,'$ar') where openid='$groupid'")->execute();

						}

					}elseif(substr($data['out_trade_no'],0,1)==5){

                        $body = json_decode($data['attach'],true);

                        $sort = $body['sort'];
                        $area = $body['area'];
                        $recharge = $body['recharge'];
                        $cellphone = $body['cellphone'];
                        $flag = $body['flag'];
                        SaveToLog::log($body);
						$insert = \Yii::$app->db->createCommand()->insert('{{%weipay_record}}',[

							"user_id"=>0,
							"type"=>5,
							"out_trade_no"=>$data['out_trade_no'],
							"total_fee"=>$data['total_fee']/100,
							"transaction_id"=>$data['transaction_id'],
							"extra"=>json_encode($data),
							"created_at"=>time(),
							"updated_at"=>time(),

						])->execute();

						if($insert){

						    $get_cookie = Yii::$app->request->cookies;
                            $autoJoinRecord = new \frontend\modules\member\models\AutoJoinRecord();
                            $autoJoinRecord->cellphone = $cellphone;
                            $autoJoinRecord->member_sort = $sort;
                            $autoJoinRecord->member_area = $area;
                            $autoJoinRecord->recharge_type = $recharge;
                            $autoJoinRecord->extra = $get_cookie->getValue('cookie_member_extra');
                            $autoJoinRecord->origin = $flag;
                            $autoJoinRecord->price = $data['total_fee'];

                            if($autoJoinRecord->save()){

                                $autoJoinFilesText = new \frontend\models\CollectingFilesText();
                                $autoJoinFilesText->link_flag = $flag;
                                $autoJoinFilesText->flag = 'auto_w_'.$cellphone.mt_rand(1000,9999);
                                if(!$autoJoinFilesText->save()){

                                    SaveToLog::log($autoJoinFilesText->errors);

                                }
                            }
						}
					}
			}

		}

	}

	
	/**
	 * 
	 * notify回调方法，该方法中需要赋值需要输出的参数,不可重写
	 * @param array $data
	 * @return true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
	 */
	final public function NotifyCallBack($data)
	{
		$msg = "OK";
		$result = $this->NotifyProcess($data, $msg);
		
		if($result == true){
			$this->SetReturn_code("SUCCESS");
			$this->SetReturn_msg("OK");
		} else {
			$this->SetReturn_code("FAIL");
			$this->SetReturn_msg($msg);
		}
		return $result;
	}
	
	/**
	 * 
	 * 回复通知
	 * @param bool $needSign 是否需要签名输出
	 */
	final private function ReplyNotify($needSign = true)
	{
		//如果需要签名
		if($needSign == true &&
			$this->GetReturn_code($return_code) == "SUCCESS")
		{
			$this->SetSign();
		}
		WxPayApi::replyNotify($this->ToXml());
	}
}