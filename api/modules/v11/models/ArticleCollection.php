<?php

namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;

class ArticleCollection extends ActiveRecord
{
    public $_article;
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
        return [
            'id','article_id'=>function(){return $this->_article['id'];},'title'=>function(){return $this->_article['title'];},'miaoshu'=>function(){return $this->_article['miaoshu'];},'wimg'=>function(){return $this->_article['wimg'];},'article_created_at'=>function(){return $this->_article['created_at'];},"collection_created_at"=>"created_at",
        ];
    }
}
