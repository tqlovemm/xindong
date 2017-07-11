<?php
namespace api\modules\v11\controllers;

use yii;
use yii\rest\ActiveController;
use yii\myhelper\Decode;
use yii\filters\RateLimiter;
use yii\myhelper\Response;
use api\modules\v11\models\User2;
use api\modules\v11\models\User;
use api\modules\v11\models\GirlFlopRecord;
use api\modules\v11\models\GirlAuthentication;
use api\modules\v11\models\GirlFlopBoy;
use yii\myhelper\Easemob;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\Query;

class GirlFlopController extends ActiveController {

    public $modelClass = 'api\modules\v11\models\GirlFlop';
    public $serializer = [
        'class' => 'app\components\Serializer',
        'collectionEnvelope' => 'data',
    ];

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::className(),
            'enableRateLimitHeaders' => true,
        ];
        return $behaviors;
    }

    public function actions() {
        $action = parent::actions();
        unset($action['index'], $action['view'], $action['create'], $action['update'], $action['delete']);
        return $action;
    }

    public function actionIndex() {
        $id = isset($_GET['id'])?$_GET['id']:'';
        $address = isset($_GET['address'])?$_GET['address']:'';
        $morelike = isset($_GET['morelike'])?$_GET['morelike']:'';
//        $decode = new Decode();
//        if(!$decode->decodeDigit($id)){
//            Response::show(210,'参数不正确');
//        }
        $userInfo = User2::findOne($id);
        if(!$userInfo){
            Response::show('201','用户不存在');
        }
        if($userInfo['sex'] == 1){
            $sex = 0;
        }else{
            Response::show('201','该用户是男生');
        }
        //环信好友
        $friends = $this->Easemob()->findFriend($userInfo['username']);
        if(!isset($friends['action'])){
            Response::show('201','该用户不在环信中');
        }
        $userIds = User2::find()->select('id')->where(['username'=>$friends['data']])->all();
        $exceptId = array();
        foreach($userIds as $item){
            $exceptId[] = $item['id'];
        }
        $exceptId2 = implode(',',$exceptId);
        //已翻牌过
        $flopid = array();
        $flopid2 = '';
        $model = new $this->modelClass();
        $flopres = $model::find()->select('flop_userid')->where(['user_id'=>$id])->all();
        if($flopres){
            foreach($flopres as $list){
                $flopid[] = $list['flop_userid'];
            }
            $flopid2 = implode(',',$flopid);
        }
        if($flopid2){
            $exceptId2 .= $flopid2;
        }
        $query = User2::find()
            ->select('username,nickname,identify,pre_user.id,sex,address,birthdate,img_url,groupid')
            ->JoinWith('image')->JoinWith('profile');
        $where = "sex = {$sex} AND img_url is not null";
        if($address){
            if($address == "海外"){
                $sxhw = (new Query())->select('shortname')->from('{{%member_address_link}}')->where(['parentid'=>0])->all();
                for($i=0;$i<count($sxhw);$i++){
                    $where .= " AND address not like '%".$sxhw[$i]['shortname']."%'";
                }
            }else{
                $where .= " AND address like '%".$address."%'";
            }
        }
        if($exceptId2){
            $where .= " AND pre_user.id not in({$exceptId2})";
        }
        if($morelike){
            if($morelike == 1){
                $query->JoinWith('boylike')->orderBy("is_like desc");
            }elseif($morelike == 2){
                $query->JoinWith('boylike')->orderBy("is_like asc")->orderBy("rand()");
            }
        }else{
            $query->orderBy("rand()");
        }
        $info = $query->where($where);
        return new ActiveDataProvider([
            'query' =>  $info,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }
    public function actionCreate(){
        $id = Yii::$app->request->getBodyParam('user_id');
        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $model = new $this->modelClass();
        $model->load(Yii::$app->request->getBodyParams(), '');
        $flop_userid = $model->flop_userid;
        $flop_type = $model->flop_type;
        $renzheng = GirlAuthentication::find()->where(['user_id'=>$id])->orderBy("created_at desc")->one();
        $time = strtotime('today');
        $recordwhere = "user_id = {$id} AND created_at >= {$time}";
        $recordcount = GirlFlopRecord::find()->where($recordwhere)->count();
        if($renzheng['status'] == 1){
            $maxflop = 50;
        }else{
            $maxflop = 20;
        }
        //翻牌限制
        if($recordcount >= $maxflop){
            Response::show('202','超过每日翻牌限制！',"翻牌错误");
        }
        $flop = $model->find()->where(['user_id'=>$id,'flop_userid'=>$flop_userid])->one();
        if($flop){
            Yii::$app->db->createCommand("update {{%girl_flop}} set flop_type=$flop_type where user_id={$id} and flop_userid={$flop_userid}")->execute();
        }else{
            $model->status = 1;
            if(!$model->save()){
                // return $model->getFirstErrors();
                Response::show('201','操作失败',"翻牌失败");
            }
        }
        //记录翻牌
        $record = new GirlFlopRecord();
        $record->user_id=$id;
        $record->save();
        //男生热度记录
        $boylike = new GirlFlopBoy();
        $boyres = $boylike->find()->where(['user_id'=>$flop_userid])->one();
        if($boyres){
            if($flop_type == 1){
                Yii::$app->db->createCommand("update {{%girl_flop_boy}} set is_like=is_like+1 where id={$boyres['id']}")->execute();
            }else{
                Yii::$app->db->createCommand("update {{%girl_flop_boy}} set is_dislike=is_dislike+1 where id={$boyres['id']}")->execute();
            }
        }else{
            $boylike->user_id = $flop_userid;
            $boylike->status = 1;
            if($flop_type == 1){
                $boylike->is_like = 1;
                $boylike->is_dislike = 0;
            }else{
                $boylike->is_like = 0;
                $boylike->is_dislike = 1;
            }
            $boylike->save();
        }
        //推送
        $user = User2::find()->where(['id'=>$flop_userid])->one();
        if($user['groupid'] == 1 && $flop_type == 1){
            $girluser = User::find()->where(['id'=>$id])->one();
            $cid = $user['cid'];
            $title = "有女生喜欢你，成为会员可以收到好友通知哦。";
            $msg = "有女生喜欢你，成为会员可以收到好友通知哦。";
            $date = time();
            if($girluser['avatar']){
                $icon = $girluser['avatar'];
            }else{
                $icon = '';
            }
            $extras = json_encode(array('push_title'=>urlencode($title),'push_user_id'=>$id,'push_content'=>urlencode($msg),'push_type'=>'SSCOMM_LIKE_FLOP'));
            Yii::$app->db->createCommand("insert into {{%app_push}} (type,status,cid,title,msg,extras,platform,response,icon,created_at,updated_at) values('SSCOMM_LIKE_FLOP',2,'$cid','$title','$msg','$extras','all','NULL','$icon',$date,$date)")->execute();
            Response::show('200','翻牌成功',"翻牌成功");
        }else{
            Response::show('203','翻牌成功',"翻牌成功");
        }
    }
    public function actionView($id){
        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $model = new $this->modelClass();
        $res = $model::find()->where(['user_id'=>$id,'flop_type'=>1])->orderBy("created_at desc")->all();
        $ids = array();
        foreach($res as $v){
            $ids[] = $v['flop_userid'];
        }
        if($ids){
            //环信好友
            $userInfo = User2::findOne($id);
            $friends = $this->Easemob()->findFriend($userInfo['username']);
            if(!isset($friends['action'])){
                Response::show('201','该用户不在环信中');
            }
            $userIds = User2::find()->select('id')->where(['username'=>$friends['data']])->all();
            $exceptId = array();
            foreach($userIds as $item){
                $exceptId[] = $item['id'];
            }
            $ids2 = implode(',',$ids);
            $pagination = new Pagination([
                'defaultPageSize' => 10,
                'totalCount' => User2::find()->where("pre_user.id in({$ids2}) ORDER BY field(pre_user.id,{$ids2})")->count(),
            ]);
            $pagination->validatePage = false;
            $maxpage = ceil($pagination->totalCount/$pagination->defaultPageSize);
            $boysres = User2::find()->where("pre_user.id in({$ids2}) ORDER BY field(pre_user.id,{$ids2})")
                ->offset($pagination->offset)->limit($pagination->limit)
                ->with('image')->with('profile')->all();

            $newarr = array();
            for($i=0;$i<count($boysres);$i++){
                if(in_array($boysres[$i]['id'],$exceptId)){
                    $newarr[$i]['is_friend'] = 1;
                }else{
                    $newarr[$i]['is_friend'] = 2;
                }
                $newarr[$i]['info']['user_id'] = $boysres[$i]['id'];
                $newarr[$i]['info']['username'] = $boysres[$i]['username'];
                $newarr[$i]['info']['nickname'] = $boysres[$i]['nickname'];
                $newarr[$i]['info']['sex'] = $boysres[$i]['sex'];
                $newarr[$i]['info']['address'] = $boysres[$i]['profile']['address'];
                $newarr[$i]['info']['groupid'] = $boysres[$i]['groupid'];
                $newarr[$i]['info']['birthdate'] = $boysres[$i]['profile']['birthdate'];
                $newarr[$i]['info']['avatar'] = $boysres[$i]['image']['img_url'];
            }
            return $this->datares(200,$maxpage,$newarr);
        }else{
            Response::show('200','',[]);
        }
    }
    protected function datares($code,$maxpage,$data,$message='ok'){
        $mess = $message;
        return array('code'=>$code,'message'=>$mess,'maxpage'=>$maxpage,'data'=>$data);
    }
    public function Easemob(){

        $option = [
            'client_id'  => Yii::$app->params['client_id'],
            'client_secret' => Yii::$app->params['client_secret'],
            'org_name' => Yii::$app->params['org_name'],
            'app_name' => Yii::$app->params['app_name'] ,
        ];

        $se = new Easemob($option);
        return $se;
    }
}

