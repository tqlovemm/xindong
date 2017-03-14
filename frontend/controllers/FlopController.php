<?php

namespace frontend\controllers;

use app\models\FlopContentData;
use backend\modules\exciting\models\Website;
use backend\modules\flop\models\Flop;
use backend\modules\flop\models\FlopContent;
use frontend\models\CollectingFilesText;
use frontend\models\FlopYanZhen;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\myhelper\Address;
use yii\myhelper\BiHua;
use yii\myhelper\Cart;
class FlopController extends Controller
{
    public  $enableCsrfValidation = false;
    public $layout = 'basic';
    public $cart;
    public $flag;
    public $pre_url;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','encryption'],
                'rules' => [
                    [
                        'actions' => ['signup', 'develop', 'help','encryption'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','encryption'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }


   public function __construct($id, $module)
   {
       if(!Yii::$app->session->isActive){
           Yii::$app->session->open();
       }
       $this->pre_url = Yii::$app->params['imagetqlmm'];
       parent::__construct($id, $module);

        $this->flag = $_SESSION['flag'] =isset($_SESSION['flag'])?$_SESSION['flag']:time().rand(1000,9999);
       if(!isset($_SESSION['cat'])){
           $_SESSION['cat']=null;
       }

       $this->cart = Cart::Getcat();
   }

    public function actionIndex(){


        return $this->render('index');

    }
    public function actionGreat (){

        return $this->render('great',['area'=>'上海']);

    }

    public function actionShowMsg($number,$id){

        $session = Yii::$app->session;
        if(!$session->isActive){
            $session->open();
        }
        $session->set('flop_number',$id);

        $model = CollectingFilesText::findOne($number);
        $imgs = $model->imgs;

        return $this->render('show-msg',['model'=>$model,'imgs'=>$imgs]);

    }

    public function actionText(){

        $query = FlopContent::find()->innerJoinWith('file')->innerJoinWith('imgs')->where(['area' => "宁夏",'is_cover'=>1])->asArray()->all();

        echo '<pre>';
        return var_dump($query);

    }

    public function actionAreaChoice(){

        $address = new Address();
        $local =  $address->getAddress();
        if(empty($local)){$local =  '未知位置';}
        $model = ArrayHelper::map(Flop::find()->where('id!=49')->andWhere('id!=118')->andWhere("area!='$local'")->andWhere(['sex'=>0])->orderBy('content ASC')->all(),'area','area');
        return $this->render('area-choice',['area'=>$local,'model'=>$model]);
    }

    /*区域选择*/
    public function actionAjaxArea($id,$local){
        $session = Yii::$app->session;
        if(!$session->isActive){
            $session->open();
        }
        $exist = FlopContentData::find()->select('content')->where(['>','created_at',time()-86400*5])->asArray()->all();
        $exists = array_unique(array_filter(explode(',',implode(',',ArrayHelper::map($exist,'content','content')))));
        $count = Yii::$app->db->createCommand("SELECT count(*) FROM {{%flop_content}}  WHERE is_cover=1 and area='$local'")->queryScalar();
        if(!empty($session->get('flop_number'))){

            $query = FlopContent::find()->where(['id'=>$session->get('flop_number')])->asArray()->one();
            $session->set('flop_number','');
            //return json_encode($query);

        }else{

            $gailv = mt_rand(1,10);
            if(in_array($gailv,[1,2,3,4,5,6])){
                $query =FlopContent::find()->where(['area'=>$local,'is_cover'=>1,'sex'=>0])->andWhere("id!=$id")->andWhere(['not in', 'id', $exists])->orderBy('created_at desc')->limit(10)->asArray()->all();
            }elseif(in_array($gailv,[7,8,9])){
                $query =FlopContent::find()->where(['area'=>$local,'is_cover'=>1,'sex'=>0])->andWhere("id!=$id")->andWhere(['not in', 'id', $exists])->andWhere(['<','like_count',20])->asArray()->all();
            }else{
                $query =FlopContent::find()->where(['area'=>$local,'is_cover'=>1,'sex'=>0])->andWhere("id!=$id")->andWhere(['not in', 'id', $exists])->andWhere(['>','like_count',20])->asArray()->all();
            }
            if(empty($query)){
                // $query = FlopContent::find()->andWhere("id!=$id")->innerJoinWith('file')->innerJoinWith('imgs')->where(['area' => "$local",'is_cover'=>1])->asArray()->all();
                $query = FlopContent::find()->where(['area' => "$local",'is_cover'=>1,'sex'=>0])->andWhere("id!=$id")->asArray()->all();
            }
            $query = $query[mt_rand(0,count($query)-1)];
           // return json_encode($query[mt_rand(0,count($query)-1)]);
        }

        $model = CollectingFilesText::findOne($query['number']);

        if(!empty($model)){

            echo <<<EOF
        
        <div class='demo__card'>
            <div class='member__id hide'>$query[id]</div>
            <div class='demo__card__top brown'>
                <a class='flop__img_tan' href='/flop/show-msg/?number=$query[number]&id=$query[id]' data-path=$query[content] data-title='编号:$query[number]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$query[weight]kg/$query[height]cm'>
                    <div class='demo__card__img' style='background-image: url($this->pre_url$query[content]);background-size: cover;background-position: center;background-repeat: no-repeat;position: relative;'></div>
                </a>
                <div class='demo__card__info' style='padding:10px;'>
                    <div class='pull-left'>
                        <span>编号：$query[number]</span>
                    </div>
                    <div class='pull-right'>
                        <span>点击图片看大图</span>
                    </div>
                </div>
            </div>
        </div>
EOF;
        }else{

            echo <<<EOF
        
        <div class='demo__card'>
            <div class='member__id hide'>$query[id]</div>
            <div class='demo__card__top brown'>
                <a class='flop__img_tan' href=$query[content] data-lightbox='dd' data-path=$query[content] data-title='编号:$query[number]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$query[weight]kg/$query[height]cm'>
                    <div class='demo__card__img' style='background-image: url($this->pre_url$query[content]);background-size: cover;background-position: center;background-repeat: no-repeat;position: relative;'></div>
                </a>
                <div class='demo__card__info' style='padding:10px;'>
                    <div class='pull-left'>
                        <span>编号：$query[number]</span>
                    </div>
                    <div class='pull-right'>
                        <span>点击图片看大图</span>
                    </div>
                </div>
            </div>
        </div>
EOF;

        }


    }


    public function actionGirl(){

        return $this->render('girl');
    }
    public function actionGirlAjaxCarefully($id){

        $query =FlopContent::find()->where(['sex'=>1])->andWhere("id!=$id")->asArray()->all();

        if(empty($query)){

            $query = array([  'id' => '99999',
                'flop_id' =>  'none',
                'area' =>  '无',
                'number' =>'none',
                'content' =>  '' ,
                'sex' => '0',
                'height' =>  '0',
                'weight' =>  '0',
                'store_name' =>  '没有了',
                'path' =>  'http://13loveme.com/images/flop/none.jpg',
                'other' =>  '0' ,
                'updated_at' =>  '0',
                'created_at' =>  '1459910915' ,
                'created_by' =>  '10000' ,
                'is_cover' =>  '0' ,
                'like_count' =>  '0' ,
                'nope_count' =>  '0' ,
                'need_count' =>  '0']);
        }

        return json_encode($query[mt_rand(0,count($query)-1)]);

    }


    public function actionAjaxCarefully($type=0){

        $exist = FlopContentData::find()->select('content')->where(['>','created_at',time()-86400*5])->asArray()->all();

        $exists = array_unique(array_filter(explode(',',implode(',',ArrayHelper::map($exist,'content','content')))));


        if($type==0){

            /*男神或者精选*/
            $query =FlopContent::find()->where(['not in', 'id', $exists])->andWhere(['flop_id'=>118,'sex'=>0])->orWhere("like_count>10")->andWhere(['sex'=>0])->asArray()->all();

        }elseif($type==1){

            /*好评*/
            $query =FlopContent::find()->where(['not in', 'id', $exists])->andWhere(["other"=>1,'sex'=>0])->asArray()->all();


        }elseif($type==2){

            /*最新*/
            $query =FlopContent::find()->where(['not in', 'id', $exists])->andWhere('flop_id!=118')->andWhere(['sex'=>0])->orderBy('created_at desc')->limit(40)->asArray()->all();

        }else{

            /*优质*/
            $query =FlopContent::find()->where('other=:other',[':other'=>2])->andWhere(['sex'=>0])->asArray()->all();

        }

        $query = $query[mt_rand(0,count($query)-1)];


        $model = CollectingFilesText::findOne($query['number']);

        if(!empty($model)){

            echo <<<EOF
        
        <div class='demo__card'>
            <div class='member__id hide'>$query[id]</div>
            <div class='demo__card__top brown'>
                <a class='flop__img_tan' href='/flop/show-msg/?number=$query[number]&id=$query[id]' data-path=$query[content] data-title='编号:$query[number]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$query[weight]kg/$query[height]cm'>
                    <div class='demo__card__img' style='background-image: url($this->pre_url$query[content]);background-size: cover;background-position: center;background-repeat: no-repeat;position: relative;'></div>
                </a>
                <div class='demo__card__info' style='padding:10px;'>
                    <div class='pull-left'>
                        <span>编号：$query[number]</span>
                    </div>
                    <div class='pull-right'>
                        <span>点击图片看大图</span>
                    </div>
                </div>
            </div>
        </div>
EOF;
        }else{

            echo <<<EOF
        
        <div class='demo__card'>
            <div class='member__id hide'>$query[id]</div>
            <div class='demo__card__top brown'>
                <a class='flop__img_tan' href=$query[content] data-lightbox='dd' data-path=$query[content] data-title='编号:$query[number]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$query[weight]kg/$query[height]cm'>
                    <div class='demo__card__img' style='background-image: url($this->pre_url$query[content]);background-size: cover;background-position: center;background-repeat: no-repeat;position: relative;'></div>
                </a>
                <div class='demo__card__info' style='padding:10px;'>
                    <div class='pull-left'>
                        <span>编号：$query[number]</span>
                    </div>
                    <div class='pull-right'>
                        <span>点击图片看大图</span>
                    </div>
                </div>
            </div>
        </div>
EOF;

        }

    }



    public function actionArea(){

        $address = new Address();
        $model = Website::find()->with('photo')->asArray();
        $girlPhoto = $model->where(['website_id'=>3])->one();

        $local =  $address->getAddress();
        $exec = Yii::$app->db->createCommand("select * from {{%flop}} where area='$local' and sex=0")->queryOne();

        if(isset($_GET['area'])){
            $yan = new FlopYanZhen();
            $local = $_GET['area'];
            $bi = new BiHua();

            if(isset($_SESSION['password'])&&$_SESSION['password']==$bi->find($local)){

                return $this->render('index',
                    [
                        'area'=>$local,'girlPhoto'=>$girlPhoto['photo']
                    ]
                );
            }

            if($yan->load(Yii::$app->request->post())){

                $res = Yii::$app->request->post()['FlopYanZhen']['password'];


                if($yan->validate()&&($res==$bi->find($local))){

                    $_SESSION['password']=$bi->find($local);

                    return $this->render('index',
                        [
                            'area'=>$local,'girlPhoto'=>$girlPhoto['photo']
                        ]
                    );
                }
            }

            return $this->render('yan-zhen',
                ['model'=>$yan,'local'=>$local,]
            );

        }


        if(empty($local)||empty($exec)){

           return $this->redirect('area-choice');


        }else{

            return $this->render('index',
                [
                    'area'=>$local,'girlPhoto'=>$girlPhoto['photo']
                ]
            );
        }
    }


    public function actionFlopNope($id){

        if(empty($id)){

            return ;
        }
        $query = (new Query())->select('number')->from('pre_flop_content')->one();

        Yii::$app->db->createCommand("update {{%flop_content}} set nope_count=nope_count+1 where id=$id")->execute();
        echo $query['number'];
    }


    public function actionFlopLike($id){


        if(empty($id)){

            return ;
        }
        Yii::$app->db->createCommand("update {{%flop_content}} set like_count=like_count+1 where id=$id")->execute();

    }

    public function actionFlopList($flag,$sex=0){

        $flopData = new FlopContentData();
        $isFlag = $flopData::find()->where('flag='.$flag)->asArray()->one();
        $girlModel = Website::find()->with('photo')->asArray();
        $girlPhoto = $girlModel->where(['website_id'=>3])->one();

        $model = array();
        if(!empty($isFlag['content'])){

            $query = Yii::$app->db->createCommand("select content from {{%flop_content_data}} where flag=$flag")->queryOne();
            $flop_content_id = array_filter(explode(',',$query['content']));

            foreach($flop_content_id as $id){
                $model_child = Yii::$app->db->createCommand("select * from {{%flop_content}} where id=$id")->queryOne();
                array_push($model,$model_child);
            }
        }

        $priority = $flopData::find()->select('priority')->where(['flag'=>$flag])->asArray()->one();
        $prioritys = array_filter(explode(',',$priority['priority']));

        if($sex==0){

            return $this->render('flop-list',[

                'model'=>$model,
                'flag'=>$this->flag,
                'prioritys'=>$prioritys,'girlPhoto'=>$girlPhoto['photo']

            ]);

        }else{

            return $this->render('girl-flop-list',[

                'model'=>$model,
                'flag'=>$this->flag,
                'prioritys'=>$prioritys,'girlPhoto'=>$girlPhoto['photo']

            ]);

        }

    }

    public function actionAddFlopList($id=null){

        if(empty($id)){

            return ;
        }

        $time = time();
        $flopData = new FlopContentData();
        $isFlag = $flopData::find()->where('flag='.$this->flag)->asArray()->one();

        $query = Yii::$app->db->createCommand("select * from {{%flop_content}} where id=$id")->queryOne();
        $this->cart->Additem($query['id'],$query['path'],$query['number'],$query['area']);

        $seo = json_encode(implode(',',array_values(ArrayHelper::map($this->cart->Itemlist(),'id','id'))));

        if(!empty($isFlag)){

            Yii::$app->db->createCommand("update {{%flop_content_data}} set content=".$seo." where flag=$this->flag")->execute();
            Yii::$app->db->createCommand("update {{%flop_content_data}} set priority=".$seo." where flag=$this->flag")->execute();

        }else{

            Yii::$app->db->createCommand("insert into {{%flop_content_data}} (content,priority,created_at,flag) VALUES($seo,$seo,$time,$this->flag)")->execute();

        }

        $flop_num = Yii::$app->db->createCommand("select content from {{%flop_content_data}} where flag=$this->flag")->queryOne();

        $count = count(explode(',',$flop_num['content']));
        return '+'.$count;


    }


    public function actionDelete($id,$flag){

        if($this->flag!==$flag){

            return $this->redirect('flop-list?flag='.$flag);
        }
        /*删除session中的人*/
        $this->cart->Delitem($id);


        $query = Yii::$app->db->createCommand("select content from {{%flop_content_data}} where flag=$this->flag")->queryOne();
        $query = array_filter(explode(',',$query['content']));

        /*删除已经加入后宫的人*/
        unset($query[array_search($id,$query)]);

        $queries = json_encode(implode(',',$query));
        Yii::$app->db->createCommand("update {{%flop_content_data}} set content=$queries where flag=$this->flag")->execute();


        $priority = Yii::$app->db->createCommand("select priority from {{%flop_content_data}} where flag=$this->flag")->queryOne();
        $priorities = array_filter(explode(',',$priority['priority']));

        /*删除首选的人*/
        if(in_array($id,$priorities)){

            unset($priorities[array_search($id,$priorities)]);

            $priorities = json_encode(implode(',',$priorities));

            Yii::$app->db->createCommand("update {{%flop_content_data}} set priority=$priorities where flag=$this->flag")->execute();

        }

        return $this->redirect('flop-list?flag='.$flag);

    }

    public function actionPriority($id){

        $priority = Yii::$app->db->createCommand("select priority from {{%flop_content_data}} where flag=$this->flag")->queryOne();

        $priorities = array_filter(explode(',',$priority['priority']));
        if(in_array($id,$priorities)){

            unset($priorities[array_search($id,$priorities)]);

            $priorities = json_encode(implode(',',$priorities));

            Yii::$app->db->createCommand("update {{%flop_content_data}} set priority=$priorities where flag=$this->flag")->execute();

            return;
        }
        $id = ','.$id;

        Yii::$app->db->createCommand("update {{%flop_content_data}} set priority=concat(priority,'$id') where flag=$this->flag")->execute();

    }


    public function actionClearFlop($sex=0){


        $this->cart->Emptyitem();
        unset($_SESSION['flag']);

        if($sex==0){

            return $this->redirect('area');

        }else{

            return $this->redirect('girl');
        }


    }

    public function actionTeach($sex=0){

        if($sex==0){

            return $this->render('flop-teach');

        }else{

            return $this->render('girl-teach');

        }


    }



    public function actionModel($id){

        if($model = FlopContentData::findOne($id)!==null){
            return $model;
        }
    }


}
