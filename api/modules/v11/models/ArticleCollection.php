<?php

namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;

class ArticleCollection extends ActiveRecord
{
    public $_article;
    public $_like;
    public $_islike;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_article_collection';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aid', 'userid','status'], 'required'],
            [['aid', 'userid', 'created_at', 'updated_at', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aid' => 'Aid',
            'userid' => 'Userid',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function fields(){
        $this->_article = Yii::$app->db->createCommand("select id,title,miaoshu,wimg,created_at from {{%article}} where id=$this->aid")->queryOne();
        $this->_like = Yii::$app->db->createCommand("select userid from {{%article_like}} where aid=$this->aid")->queryAll();
        for($i=0;$i<count($this->_like);$i++){
            if($this->_like[$i]['userid'] == $this->userid){
                $this->_islike = 1;
            }
        }
        return [
            'id','article_id'=>function(){return $this->_article['id'];},'title'=>function(){return $this->_article['title'];},'miaoshu'=>function(){return $this->_article['miaoshu'];},'wimg'=>function(){return $this->_article['wimg'];},'article_created_at'=>function(){return $this->_article['created_at'];},"collection_created_at"=>"created_at",'url'=>function(){return "http://120.27.226.102:82/article/article/show?id=".$this->aid."&uid=".$this->userid;},'like_count'=>function(){return count($this->_like);},'islike'=>function(){return $this->_islike?1:0;},
        ];
    }
}
