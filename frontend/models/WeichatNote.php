<?php

namespace frontend\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "pre_weichat_note".
 *
 * @property string $id
 * @property string $title
 * @property string $content
 * @property string $introduction
 * @property string $cover_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $enable_comment
 * @property integer $status
 * @property string $url
 * @property string $number
 * @property string $avatar
 *
 * @property WeichatNoteContent[] $weichatNoteContents
 */
class WeichatNote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_weichat_note';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'introduction', 'cover_id', 'created_at', 'updated_at', 'created_by', 'url', 'number', 'avatar'], 'required'],
            [['cover_id', 'created_at', 'updated_at', 'created_by', 'enable_comment', 'status'], 'integer'],
            [['title', 'content'], 'string', 'max' => 128],
            [['introduction'], 'string', 'max' => 512],
            [['url', 'avatar'], 'string', 'max' => 255],
            [['number'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'introduction' => 'Introduction',
            'cover_id' => 'Cover ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'enable_comment' => 'Enable Comment',
            'status' => 'Status',
            'url' => 'Url',
            'number' => 'Number',
            'avatar' => 'Avatar',
        ];
    }

    public function getPhotos($type)
    {

        if($type==1){

            $query = (new Query())->select('id,name,path,thumb,expire,note_count,status')
                ->from('{{%weichat_note_content}}')
                ->where('album_id=:id', [':id' => $this->id])->all();
        }else{

            $query = (new Query())->select('id,name,path,thumb,expire,note_count,status')
                ->from('{{%weichat_note_content}}')
                ->where('album_id=:id', [':id' => $this->id])->andWhere(['like','name',$type])->all();
        }
        
        return $query;
    }
    public function getTop($number)
    {
        $query = (new Query())->select('id,name,path,thumb,expire,note_count,status')
            ->from('{{%weichat_note_content}}')
            ->where('album_id=:id', [':id' => $this->id])->andWhere('id!=44')->orderBy('note_count desc')->limit($number)->all();

        return $query;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWeichatNoteContents()
    {
        return $this->hasMany(WeichatNoteContent::className(), ['album_id' => 'id']);
    }
}
