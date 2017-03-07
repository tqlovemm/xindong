<?php

namespace backend\modules\dating\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\dating\models\DatingContent;

/**
 * DatingContentSearch represents the model behind the search form about `backend\modules\weekly\models\DatingContent`.
 */
class DatingContentSearch extends DatingContent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'album_id', 'created_at', 'created_by', 'is_cover'], 'integer'],
            [['name', 'thumb', 'path', 'store_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DatingContent::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'album_id' => $this->album_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'is_cover' => $this->is_cover,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'thumb', $this->thumb])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'store_name', $this->store_name]);

        return $dataProvider;
    }
}
