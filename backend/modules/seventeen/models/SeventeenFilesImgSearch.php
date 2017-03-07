<?php

namespace backend\modules\seventeen\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\seventeen\models\SeventeenFilesImg;

/**
 * SeventeenFilesImgSearch represents the model behind the search form about `backend\modules\seventeen\models\SeventeenFilesImg`.
 */
class SeventeenFilesImgSearch extends SeventeenFilesImg
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'text_id', 'type'], 'integer'],
            [['img'], 'safe'],
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
        $query = SeventeenFilesImg::find()->orderBy('text_id asc');

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
            'text_id' => $this->text_id,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'img', $this->img]);

        return $dataProvider;
    }
}
