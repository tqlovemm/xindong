<?php

namespace api\modules\v6\models;
use Yii;
use app\components\db\ActiveRecord;
use yii\db\Query;
use api\modules\v2\models\User;
use api\modules\v7\models\Like;


/**
 *  This is the model class for table "pre_app_words".
 * @property integer $id;
 * @property string $content;
 * @property string $img;
 * @property string $address;
 * @property integer $user_id;
 * @property integer $flag;
 * @property integer $status;
 * @property integer $created_at;
 * @property integer $updated_at;
 *
*/
class Word extends ActiveRecord
{

    public $img_url;
    public $comment;
    public $comment_count;
    public $like_count;

    public static function tableName(){
        return '{{%app_words}}';
    }

    public function rules()
    {
        return [
            [['user_id','img'],'required'],
            [['content','img','address'],'string'],
            [['user_id','created_at','updated_at','flag','status'],'integer'],
        ];
    }

    public function attributeLabels(){

        return [
            'id'    =>  '帖子编号',
            'content'   =>  '帖子内容',
            'img'   =>  '图片',
            'address'   =>  'address',
            'user_id'   =>  'user_id',
            'flag'   =>  'flag',
            'status'   =>  'status',
            'created_at'=>  'created_at',
            'updated_at'=>  'updated_at',

        ];
    }

    protected function getNickname(){

        $userInfo = (new Query())->select('nickname,username')->from('{{%user}}')->where(['id'=>$this->user_id])->one();
        if(!$userInfo['nickname']){
            $userInfo['nickname'] = $userInfo['username'];
        }
        unset($userInfo['username']);
        return $userInfo['nickname'];
    }

    protected function getAvatar(){

        $userInfo = (new Query())->select('avatar')->from('{{%user}}')->where(['id'=>$this->user_id])->one();

        return $userInfo['avatar'];
    }

    protected function getLikeItemsArray(){

        //点赞用户头像
        $info = (new Query())->select('user_id')->from('{{%app_words_like}}')->where(['words_id'=>$this->id])->all();
        $uid = array();
        foreach($info as $item){
            $uid[] = $item['user_id'];
        }
        $id = implode(',',$uid);
        if($id){
            $userInfo = (new Query())->select('avatar,id as user_id')->from('{{%user}}')->where(" id in ({$id})")->all();
            return $userInfo;
        }
        return [];
    }

    protected function getInfo($id){
        $info = User::find()->select('id as user_id,avatar as secondUrl,nickname as secondName,username')->where(['id'=>$id])->asArray()->one();
        return $info;
    }

    protected function getCommentCount(){
        $count = (new Query())
            ->select('id')
            ->from('pre_app_words_comment')
            ->where(['words_id'=>$this->id,'flag'=>0])
            ->count();
        if(!$count){

            $count = 0;
        }
        return $count;

    }

    protected function getCommentItemsArray(){

        $info = (new Query())
            ->select('comm.id as comment_id,words_id,first_id,second_id,img,comment,comm.created_at,user.avatar as firstUrl,user.nickname as firstName,user.username,')
            ->from('pre_app_words_comment as comm')
            ->join('left join','pre_user as user','user.id=comm.first_id')
            ->where(['words_id'=>$this->id,'flag'=>0])
            ->limit(5)
            ->orderBy('comment_id asc')
            ->all();

        $name = array();
        if($info){

            foreach($info as $list){
                if(!$list['firstName']){
                    $list['firstName'] = $list['username'];
                }
                unset($list['username']);
                if($list['second_id']){
                    $second_user_info= $this->getInfo($list['second_id']);

                    if($second_user_info){
                        if(!$second_user_info['secondName']){
                            $second['secondName'] = $second_user_info['username'];
                        }else{
                            $second['secondName'] = $second_user_info['secondName'];
                        }

                        $second['secondUrl'] = $second_user_info['secondUrl'];
                        $name[] = array_merge($list,$second);
                    }

                }else{
                    $name[] = $list;
                }

            }
        }

        return $name;
    }

    public function fields(){

        return [
            'wid'=>'id',
            'user_id','address','img','flag',
            'content','status','created_at'=>function($model){
                return (string)$model['created_at'];
            },'avatar','nickname','liked','likeCount','likeItemsArray','commentCount','commentItemsArray'
        ];
    }

    public function getLikeCount(){
    $user_id = isset($_GET['user_id'])?$_GET['user_id']:'';
    if($user_id){
        $count = (new Query())->select('id')->from('{{%app_words_like}}')->where(['words_id'=>$this->id])->all();
        $count = count($count);
    }else{
        $count = 0;
    }
    return $count;

}

    public function getLiked(){

        $user_id = isset($_GET['user_id'])?$_GET['user_id']:'';
        $second_id = isset($_GET['second_id'])?$_GET['second_id']:'';
        if($second_id){
            if($user_id != $second_id){
                //他人查看自己的所有动态
                $info  = (new Query())->select('id')->from('{{%app_words_like}}')->where(['user_id'=>$second_id,'words_id'=>$this->id])->one();
            }elseif($user_id == $second_id) {
                //用户查看自己的所有动态
                $info  = (new Query())->select('id')->from('{{%app_words_like}}')->where(['user_id'=>$user_id,'words_id'=>$this->id])->one();
            }else {
                $info = 0;
            }
        }else{
            $info  = (new Query())->select('id')->from('{{%app_words_like}}')->where(['user_id'=>$user_id,'words_id'=>$this->id])->one();
        }


        if($info){
            $liked = 1;
        }else{
            $liked = 0;
        }
        return $liked;


    }


    public function afterDelete()
    {

        parent::afterDelete();
        //删除评论图片
        /*$imgs = Reply::find()->where(['words_id'=>$this->id])->all();
        foreach($imgs as $list){
            if($list['img']){
                $this->DeleteImg($list['img']);
            }
        }*/
        //删除评论
        Reply::deleteAll(['words_id'=>$this->id]);

        //删除点赞
        Like::deleteAll(['words_id'=>$this->id]);
    }

}