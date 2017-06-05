<?php

namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;

class Article extends ActiveRecord
{
    public $_user;
    public $_comment;
    public $_label;
    public $_uid;
    public $_iscollection;
    public $_islike;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_id', 'title', 'wimg', 'content', 'wtype', 'wclick', 'wdianzan', 'hot','status'], 'required'],
            [['created_id', 'wtype','wlabel','yuanchuang', 'wclick', 'wdianzan', 'hot', 'created_at', 'updated_at', 'status'], 'integer'],
            [['content'], 'string'],
            [['title','miaoshu'], 'string', 'max' => 100],
            [['wimg'], 'string', 'max' => 255]
        ];
    }

    public function fields(){
        $this->_user = Yii::$app->db->createCommand("select nickname,avatar,sex,groupid from {{%user}} where id=$this->created_id")->queryOne();
        $this->_comment = Yii::$app->db->createCommand("select aid from {{%article_comment}} where aid=$this->id")->queryAll();
        $this->_uid = $_GET['uid'];
        $this->_iscollection = Yii::$app->db->createCommand("select status from {{%article_collection}} where aid=$this->id and userid=$this->_uid")->queryOne();
        $this->_islike = Yii::$app->db->createCommand("select status from {{%article_like}} where aid=$this->id and userid=$this->_uid")->queryOne();
        $this->_label = Yii::$app->db->createCommand("select labelname,thumb from {{%article_label}} where lid=$this->wlabel")->queryOne();
        return [
            'article_id'=>'id','title', 'wimg', 'miaoshu','wclick','wdianzan','hot','wtype','level'=>function(){return $this->_user['groupid'];},'nickname'=>function(){return $this->_user['nickname'];},'avatar'=>function(){return $this->_user['avatar'];},'sex'=>function(){return $this->_user['sex'];},'created_at','url'=>function(){return "http://api.13loveme.com:82/article/article/show?id=".$this->id."&uid=".$this->_uid;},'comment_count'=>function(){return count($this->_comment);},'iscollection'=>function(){return $this->_iscollection?1:0;},'islike'=>function(){return $this->_islike?1:0;},'labelname'=>function(){return $this->_label['labelname'];},'labelthumb'=>function(){return $this->_label['thumb'];},'yuanchuang',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_id' => 'Created ID',
            'title' => 'Title',
            'miaoshu' => '描述',
            'wimg' => 'Wimg',
            'content' => 'Content',
            'wtype' => 'Wtype',
            'wclick' => 'Wclick',
            'wdianzan' => 'Wdianzan',
            'hot' => 'Hot',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
