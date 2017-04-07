<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/22
 * Time: 11:03
 */

namespace api\modules\v10\controllers;

use api\modules\v6\models\Reply;
use api\modules\v6\models\Word;
use api\modules\v7\models\Like;
use api\modules\v4\models\User;
use common\Qiniu\QiniuUploader;
use Yii;
use yii\base\ErrorException;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class WordController extends Controller
{

    public $modelClass = 'api\modules\v6\models\Word';
    public $serializer = [
        'class' =>  'yii\rest\Serializer',
        'collectionEnvelope'    =>  'item',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        // 注销系统自带的实现方法
        unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
        return $actions;
    }

    public function actionView($id)
    {

        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $model = $this->modelClass;
        $min_id = isset($_GET['min_id'])?$_GET['min_id']:0;
        $user_id = isset($_GET['user_id'])?$_GET['user_id']:0;
        $query = $model::find($id)
            ->select('pre_app_words.id,pre_app_words.content,pre_app_words.user_id,pre_app_words.img,pre_app_words.address,pre_app_words.created_at,user.avatar,user.nickname')
            ->join('LEFT JOIN','pre_user as user','user.id = pre_app_words.user_id')
            ->where(['pre_app_words.id'=>$id])
            ->asArray()->one();
        if($query){

            $query['wid'] = $query['id'];
            unset($query['id']);
            $query['nickname']  = $this->getName($query['user_id']);

        }else{
            Response::show('201','操作失败','该动态不存在');
        }

        //获取点赞
        $like = Like::find()->select('')->where(['words_id'=>$id])->asArray()->all();
        $count = count($like);
        $uid = array();
        foreach($like as $item){
            $uid[] = $item['user_id'];
        }
        $uid = implode(',',$uid);

        if($uid){
            $userInfo = User::find()->select('id as user_id,avatar,nickname,groupid,cid')->where(" id in ({$uid}) ")->asArray()->all();
            if($userInfo){
                foreach($userInfo as $item){

                    $item['nickname'] = $this->getName($item['user_id']);
                    $info[] = $item;
                }
                $userInfo = $info;
            }else{
                $userInfo = [];
            }

        }else{
            $userInfo = [];
        }

        //自己是否点赞过
        $liked = (new Query())->from('{{%app_words_like}}')->where(['words_id'=>$id,'user_id'=>$user_id])->count();

        if($liked){
            $query['liked'] = 1;
        }else{
            $query['liked'] = 0;
        }
        $query['likeCount'] = $count;
        $query['likeItemsArray'] = $userInfo;

        //获取评论(需评论分页)
        $comment = $this->getComment($id,$min_id);
        $query['commentItemsArray'] = $comment;
        $query['commentCount'] = $this->getCountComment($id);

        //删除本帖子的消息推送
        $message = (new Query())
            ->select('m1.id,user_id')
            ->from('{{%app_message}} as m1')
            ->join('left join','{{%app_words}} as w','m1.words_id=w.id')
            ->where(['m1.words_id'=>$id,'m1.to_id'=>$user_id])
            ->orWhere(['m1.words_id'=>$id,'w.user_id'=>$user_id])
            ->all();
        if($message){
            $data =array() ;
            foreach($message as $list){
                $data[] = $list['id'];
            }
            if($data){
                $data = implode(',',$data);
                //删除未读消息推送和更新消息
                Yii::$app->db->createCommand("delete from pre_app_push where message_id in ({$data})")->execute();
                Yii::$app->db->createCommand("update pre_app_message set is_read = 0 where id in ({$data})")->execute();
            }

        }
        return $query;
    }

    protected function getCountComment($id){
        $count = (new Query())->select('id')->from('{{%app_words_comment}}')->where(['words_id'=>$id])->all();
        return count($count);
    }


    protected function getComment($id,$comment_id){

        if($comment_id === 0){
            $comment = (new Query())
                ->select('c1.id as comment_id,words_id,first_id,second_id,img,comment,c1.created_at,user.avatar as firstUrl,user.nickname firstName,user.username as firstUsername,user2.avatar as secondUrl,user2.nickname secondName,user2.username as secondUsername')
                ->from('{{%app_words_comment}} as c1 ')
                ->leftJoin('{{%user}} as user','c1.first_id = user.id')
                ->leftJoin('{{%user}} as user2','c1.second_id = user2.id')
                ->where('c1.words_id = '.$id.' and flag = 0 ')->limit(10)->orderBy('comment_id asc')->all();
        }else{
            $comment = (new Query())
                ->select('c1.id as comment_id,words_id,first_id,second_id,img,comment,c1.created_at,user.avatar as firstUrl,user.nickname firstName,user.username as firstUsername,user2.avatar as secondUrl,user2.nickname secondName,user2.username as secondUsername')
                ->from('{{%app_words_comment}} as c1 ')
                ->leftJoin('{{%user}} as user','c1.first_id = user.id')
                ->leftJoin('{{%user}} as user2','c1.second_id = user2.id')
                ->where('c1.words_id = '.$id.' and flag = 0 and c1.id>'.$comment_id)->limit(10)->orderBy('comment_id asc')->all();
        }

        if($comment){
            $data = array();
            foreach($comment as $list){

                if($list['second_id'] == 0){
                    $list['second_id'] = '';
                }
                if(!$list['firstName']){
                    $list['firstName'] = $list['firstUsername'];
                }
                if(!$list['second_id']){
                    unset($list['secondName']);
                    unset($list['secondUrl']);

                }else{
                    if(!$list['secondName']){
                        $list['secondName'] = $list['secondUsername'];
                    }
                }
                unset($list['firstUsername']);
                unset($list['secondUsername']);
                $data[] = $list;
            }
            return $data;
        }
        return $comment;
    }


    public function actionIndex()
    {

        //查看自己所有动态
        $user_id = isset($_GET['user_id'])?$_GET['user_id']:'';
        $decode = new Decode();
        if(!$decode->decodeDigit($user_id)){
            Response::show(210,'参数不正确');
        }
        if(!$user_id){
            Response::show('201','操作失败','用户id不能少');
        }
        $sex = isset($_GET['sex'])?$_GET['sex']:null;
        //查看用户自己的动态 及他人查看自己所有动态
        if($sex === null){
            $second_id = isset($_GET['second_id'])?$_GET['second_id']:'';
            if(!$second_id){
                Response::show('201','操作失败','参数缺失');
            }
            $query = Word::find()
                ->where(['user_id'=>$user_id,'flag'=>0,'status'=>0]);

            //查看所有的动态
        }elseif($sex == 0 || $sex ==1){
            $query = Word::find()
                ->join('left join','pre_user as user','user.id=pre_app_words.user_id')
                ->where(['pre_app_words.flag'=>0,'pre_app_words.status'=>0,'sex'=>$sex]);

        }else{
            Response::show('201','操作失败','参数错误');
        }

        return new ActiveDataProvider(
            [
                'query' =>  $query,
                'pagination'    => [
                    'pagesize'  =>  15,
                ],
                'sort'  =>  [
                    'defaultOrder' =>[
                        'id'    =>  SORT_DESC,
                        'updated_at' =>SORT_DESC,
                    ]
                ]
            ]
        );

    }

    public function actionDelete($id){


        $model = $this->findModel($id);

        $decode = new Decode();
        if(!$decode->decodeDigit($model->user_id)){
            Response::show(210,'参数不正确');
        }

        $imgs = Reply::find()->where(['words_id'=>$id])->all();

        if(!$model->delete()){
            Response::show('201','操作失败','帖子删除失败');
        }
        //删除评论图片

        foreach($imgs as $list){

            if($list['img']){
                $this->DeleteImg($list['img']);
            }
        }
        //删除图片
        if($model['img']){
            $this->DeleteImg($model['img']);
        }
        Response::show('200','操作成功','帖子删除成功');
    }

    protected function findModel($id)
    {
        $modelClass = $this->modelClass;
        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function DeleteImg($imgs){
        $pre_url = Yii::$app->params['appimages'];
        $avatar_path = str_replace($pre_url,'',$imgs);
        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $qn->delete('appimages',$avatar_path);
    }

    protected function UploadImg($img,$user_id){

        $pre_url = Yii::$app->params['appimages'];
        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);

        $pathStr = "uploads";
        $savePath = $pathStr.'/'.time().rand(1,10000).'.jpg';
        file_put_contents($savePath,base64_decode($img));
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$user_id.'_'.md5(rand(1000,9999));

        $qiniu = $qn->upload_app('appimages',"uploads/user/content/$mkdir",$savePath);
        @unlink($savePath);

        return $pre_url.$qiniu['key'];
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

    protected function getName($id){

        $name = User::find()->select('username,nickname')->where(['id'=>$id])->one();
        if(empty($name['nickname'])){
            $name['nickname'] = $name['username'];
        }
        return $name['nickname'];
    }

    public function actionCreate(){

        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        $decode = new Decode();
        if(!$decode->decodeDigit($model->user_id)){
            Response::show(210,'参数不正确');
        }

        if($model->img){
            $model->img = $this->UploadImg($model->img,$model->user_id);
            if($model->img == ""){
                Response::show('202','操作失败','图片上传失败，发帖失败');
            }
        }

        //替换关键字
        $model->content = $this->ReplaceWord($model->content);
        if(!$model->save()){

            Response::show('201','操作失败','发帖失败');
        }
        //推送给关注了Ta的人
        $follower = (new Query())->from('pre_user_follow')->where(['people_id'=>$model->user_id])->all();

        if(count($follower)){

            $pushTo = array();
            foreach($follower as $item){
                $pushTo[] = $item['user_id'];//10031,10054,10114,10149,10001
            }

            $pushTo = implode(',',$pushTo);
            $cid = Yii::$app->db->createCommand("select cid from {{%user}} where id in ({$pushTo})")->queryAll();

            if(count($cid)){
                $username = $this->getName($model->user_id);

                for($i = 0 ; $i < count($cid) ; $i++){

                    if($cid[$i]['cid']){
                        $theCid = $cid[$i]['cid'];
                        $title = "你关注的好友：".$username." 有了新的动态，去看看？";
                        $msg = "你关注的好友：".$username." 有了新的动态，去看看？";
                        $date = time();
                        $icon = 'http://admin.13loveme.com/images/app_push/u=3453872033,2552982116&fm=21&gp=0.png';
                        $extras = json_encode(array('push_title'=>urlencode($title),'push_post_id'=>urlencode($model->id),'push_content'=>urlencode($msg),'push_type'=>'SSCOMM_FANS_THREAD_DETAIL'));
                        Yii::$app->db->createCommand("insert into {{%app_push}} (type,status,cid,title,msg,extras,platform,response,icon,created_at,updated_at) values('SSCOMM_FANS_THREAD_DETAIL',2,'$theCid','$title','$msg','$extras','all','NULL','$icon',$date,$date)")->execute();

                    }
                }
            }
        }
        Response::show('200','操作成功','发帖成功');
    }
}