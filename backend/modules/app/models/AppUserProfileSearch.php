<?php

namespace backend\modules\app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\app\models\AppUserProfile;

/**
 * AppUserProfileSearch represents the model behind the search form about `backend\modules\app\models\AppUserProfile`.
 */
class AppUserProfileSearch extends AppUserProfile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'worth', 'is_marry', 'height', 'weight', 'flag', 'updated_at', 'created_at', 'status'], 'integer'],
            [['number', 'file_1', 'birthdate', 'signature', 'address_1', 'address_2', 'address_3', 'address', 'description', 'mark', 'make_friend', 'hobby', 'weichat'], 'safe'],
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
        $query = AppUserProfile::find()->where(['flag'=>[1,2,3],'status'=>[1,2,3]])->orderBy('status asc');

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
            'user_id' => $this->user_id,
            'worth' => $this->worth,
            'birthdate' => $this->birthdate,
            'is_marry' => $this->is_marry,
            'height' => $this->height,
            'weight' => $this->weight,
            'flag' => $this->flag,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'file_1', $this->file_1])
            ->andFilterWhere(['like', 'signature', $this->signature])
            ->andFilterWhere(['like', 'address_1', $this->address_1])
            ->andFilterWhere(['like', 'address_2', $this->address_2])
            ->andFilterWhere(['like', 'address_3', $this->address_3])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'mark', $this->mark])
            ->andFilterWhere(['like', 'make_friend', $this->make_friend])
            ->andFilterWhere(['like', 'hobby', $this->hobby])
            ->andFilterWhere(['like', 'weichat', $this->weichat]);

        return $dataProvider;
    }
}
