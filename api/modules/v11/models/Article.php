<?php

namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;

class Article extends ActiveRecord
{
    public $_user;
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
            [['created_id', 'wtype', 'wclick', 'wdianzan', 'hot', 'created_at', 'updated_at', 'status'], 'integer'],
            [['content'], 'string'],
            [['title','miaoshu'], 'string', 'max' => 100],
            [['wimg'], 'string', 'max' => 255]
        ];
    }

    public function fields(){
        $this->_user = Yii::$app->db->createCommand("select nickname,avatar,sex,groupid from {{%user}} where id=$this->created_id")->queryOne();
        return [
            'article_id'=>'id','title', 'wimg', 'miaoshu','wclick','wdianzan','hot','wtype','level'=>function(){return $this->_user['groupid'];},'nickname'=>function(){return $this->_user['nickname'];},'avatar'=>function(){return $this->_user['avatar'];},'sex'=>function(){return $this->_user['sex'];},'created_at',
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
