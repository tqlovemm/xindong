<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/23
 * Time: 10:33
 */

namespace api\modules\v10\controllers;

use api\modules\v4\models\User;
use Yii;
use api\modules\v3\models\AppPush;
use api\modules\v7\models\Message;
use yii\db\Query;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;

class ReplyController extends Controller
{

    public $modelClass = 'api\modules\v6\models\Reply';

    public function behaviors(){

        return parent::behaviors();
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'],$actions['view'],$actions['create'],$actions['update'],$actions['delete']);
        return $actions;
    }

    protected function UploadImg($img){
        $img = base64_decode($img);
        $path = '/uploads/user/content/';
        $savepath = Yii::getAlias('@apiweb').$path;
        $t = time().'.png';
        $savename = $savepath.$t;
        file_put_contents($savename,$img,FILE_USE_INCLUDE_PATH);
        $url = Yii::$app->params['hostname'].$path.$t;
        return $url;

    }

    protected function ReplaceWord($word){

        $word = htmlspecialchars(str_replace(" ","",$word));
        $word = mb_eregi_replace('[0-9]{7}/*','****',$word);
        $arr = ['微信','微信号','微博','博客','威信','歪信','歪','扣','号码','联系方式','手机号','wx','Wx','weixin','WeiXin','WEIXIN','v','V','q','Q'];
        foreach($arr as $item){
            $word = preg_replace('/'.$item.'/u','*',$word);
        }
        return $word;
    }

    protected function getUsername($id){

        $userInfo = User::find()->where(['id'=>$id])->one();
        if(count($userInfo['nickname'])){
            $userInfo['nickname'] = $userInfo['username'];
        }
        return $userInfo['nickname'];
    }


    public function actionCreate(){

        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(),'');
        $decode = new Decode();
        if(!$decode->decodeDigit($model->first_id)){
            Response::show(210,'参数不正确');
        }
        if($model->img){
            $model->img = $this->UploadImg($model->img);
        }
        $model->comment = $this->ReplaceWord($model->comment);
        $res = (new Query())->select('user_id')->from('{{%app_words}}')->where(['id'=>$model->words_id])->one();

        if(!$res){
            Response::show('201','该帖子不存在或已删除');
        }
        if(!$model->save()){
            Response::show('201','回复评论失败');
        }

        if(mb_strlen($model->comment) > 10){
            $model->comment = mb_substr($model->comment,0,10,"UTF-8").'...';
        }else{
            $model->comment = mb_substr($model->comment,0,10,"UTF-8");
        }


        $word_owner = $res['user_id'];
        //添加消息提醒
        $message = new Message();
        $message->words_id = $model->words_id;
        $message->from_id =  $model->first_id;
        $message->comment_id =  $model->attributes['id'];
        $message->to_id = $model->second_id;
        $message->action = 2;

        //消息推送
        $push = new AppPush();
        $push->type = 'SSCOMM_NEWSCOMMENT_DETAIL';
        $push->status = 2;
        $push->is_read = 1;
        $push->icon = 'http://13loveme.com:82/images/app_push/u=1630850300,1879297584&fm=21&gp=0.png';
        $push->extras = json_encode(array('push_title'=>urlencode($push->title),'push_content'=>urlencode($push->msg),'push_post_id'=>$model->words_id,'push_type'=>$push->type));


        //多级回复
        if($model->second_id){

            //给自己和他人推送 mark
            if($model->second_id != $word_owner && $model->second_id != $model->first_id && $model->first_id != $word_owner){

                $message->to_id = $word_owner;
                $message->save();

                $pushToUser1 = $this->getUsername($message->from_id);

                $cid1 = (new Query())->select('cid')->from('{{%user}}')->where(['id'=>$word_owner])->one();
                if($cid1['cid']){

                    $push->title = $pushToUser1.' 回复了您: '.$model->comment;
                    $push->msg = $pushToUser1.' 回复了您: '.$model->comment;
                    $push->message_id = $message->attributes['id'];
                    $push->cid = $cid1['cid'];
                    $push->save();
                    $push->id = 0;
                }

                $message2 = new Message();
                $message2->words_id = $model->words_id;
                $message2->from_id =  $model->first_id;
                $message2->comment_id =  $model->attributes['id'];
                $message2->to_id = $model->second_id;
                $message2->action = 2;
                $message2->save();

                $push2 = new AppPush();
                $push2->title = $pushToUser1.' 回复了您: '.$model->comment;
                $push2->msg = $pushToUser1.' 回复了您: '.$model->comment;
                $push2->type = 'SSCOMM_NEWSCOMMENT_DETAIL';
                $push2->status = 2;
                $push2->is_read = 1;
                $push2->icon = 'http://13loveme.com:82/images/app_push/u=1630850300,1879297584&fm=21&gp=0.png';
                $push2->extras = json_encode(array('push_title'=>urlencode($push2->title),'push_content'=>urlencode($push2->msg),'push_post_id'=>$model->words_id,'push_type'=>$push2->type));
                $push2->message_id = $message2->attributes['id'];
                $cid2 = (new Query())->select('cid')->from('{{%user}}')->where(['id'=>$model->second_id])->one();

                if($cid2['cid']){
                    $push2->cid = $cid2['cid'];
                    $push2->save();
                }

                //给自己推送
            }elseif($model->second_id == $word_owner && $word_owner != $model->first_id){

                $message->to_id = $word_owner;
                $message->save();

                $push->message_id = $message->attributes['id'];
                $cid = (new Query())->select('cid')->from('{{%user}}')->where(['id' => $word_owner])->one();
                if ($cid['cid'] && $push->message_id) {

                    $pushToUser5 = $this->getUsername($word_owner);
                    $push->title = $pushToUser5.' 回复了您: '.$model->comment;
                    $push->msg = $pushToUser5.' 回复了您: '.$model->comment;
                    $push->cid = $cid['cid'];
                    $push->save();
                }

                //给评论者推送
            }elseif($model->second_id !== $word_owner && $model->first_id == $word_owner){

                $message->to_id = $model->second_id;
                $message->save();

                $push->message_id = $message->attributes['id'];
                $cid = (new Query())->select('cid')->from('{{%user}}')->where(['id' => $model->second_id])->one();
                if ($cid['cid'] && $push->message_id) {

                    $pushToUser5 = $this->getUsername($model->second_id);
                    $push->title = $pushToUser5.' 回复了您: '.$model->comment;
                    $push->msg = $pushToUser5.' 回复了您: '.$model->comment;
                    $push->cid = $cid['cid'];
                    $push->save();
                }
                //他人回复他人自己，帖子不是他的,推送给帖子主人
            }elseif($model->second_id == $model->first_id && $model->first_id != $word_owner){

                $message->to_id = $word_owner;
                $pushToUser4 = $this->getUsername($message->to_id);
                $push->title = $pushToUser4.' 回复了您: '.$model->comment;
                $push->msg = $pushToUser4.' 回复了您: '.$model->comment;
                $message->save();
                $push->message_id = $message->attributes['id'];

                $cid = (new Query())->select('cid')->from('{{%user}}')->where(['id' => $word_owner])->one();
                if ($cid['cid'] && $push->message_id) {

                    $pushToUser5 = $this->getUsername($word_owner);
                    $push->title = $pushToUser5.' 回复了您: '.$model->comment;
                    $push->msg = $pushToUser5.' 回复了您: '.$model->comment;
                    $push->cid = $cid['cid'];
                    $push->save();
                }
            }

        }else{

            // 一级回复 （帖子主人回复自己不推送消息）
            $message->to_id = $word_owner;
            if($model->first_id != $word_owner){
                $message->save();

                $cid = (new Query())->select('cid')->from('{{%user}}')->where(['id'=>$model->first_id])->one();
                if($cid['cid']){

                    $push->message_id = $message->attributes['id'];
                    $pushToUser5 = $this->getUsername($model->first_id);
                    $push->title = $pushToUser5.' 回复了您: '.$model->comment;
                    $push->msg = $pushToUser5.' 回复了您: '.$model->comment;
                    $push->cid = $cid['cid'];
                    $push->insert();
                }
            }
        }

        Response::show('200','回复评论成功');
    }

}