<?php

namespace frontend\modules\member\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\member\models\EnterTheBackground;

/**
 * EnterTheBackgroundSearch represents the model behind the search form about `frontend\modules\member\models\EnterTheBackground`.
 */
class EnterTheBackgroundSearch extends EnterTheBackground
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['allow_ip', 'forbid_ip', 'created_by'], 'safe'],
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
        if(Yii::$app->user->id!=10000){
            $query = EnterTheBackground::find()->where(['created_by'=>Yii::$app->user->identity->username])->orderBy('created_at desc')->limit(1);
        }else{
            $query = EnterTheBackground::find();
        }

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'allow_ip', $this->allow_ip])
            ->andFilterWhere(['like', 'forbid_ip', $this->forbid_ip])
            ->andFilterWhere(['like', 'created_by', $this->created_by]);

        return $dataProvider;
    }
}
