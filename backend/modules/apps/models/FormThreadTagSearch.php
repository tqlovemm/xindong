<?php

namespace backend\modules\apps\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v11\models\FormThreadTag;

/**
 * FormThreadTagSearch represents the model behind the search form about `api\modules\v11\models\FormThreadTag`.
 */
class FormThreadTagSearch extends FormThreadTag
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_id', 'created_at', 'updated_at', 'sort' ,'status'], 'integer'],
            [['tag_name', 'tag_py'], 'safe'],
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
        $query = FormThreadTag::find();

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
            'tag_id' => $this->tag_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sort' => $this->sort,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'tag_name', $this->tag_name])
            ->andFilterWhere(['like', 'tag_py', $this->tag_py]);

        return $dataProvider;
    }
}
