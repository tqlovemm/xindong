<?php

namespace backend\modules\setting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\setting\models\AppVersion;

/**
 * AppVersionSearch represents the model behind the search form about `backend\modules\setting\models\AppVersion`.
 */
class AppVersionSearch extends AppVersion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_force_update'], 'integer'],
            [['build', 'version', 'app_name', 'platform', 'update_info', 'url'], 'safe'],
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
        $query = AppVersion::find();

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
            'is_force_update' => $this->is_force_update,
        ]);

        $query->andFilterWhere(['like', 'build', $this->build])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'app_name', $this->app_name])
            ->andFilterWhere(['like', 'platform', $this->platform])
            ->andFilterWhere(['like', 'update_info', $this->update_info])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
