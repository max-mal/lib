<?php

namespace app\core\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\core\models\Libavtorname;

/**
 * LibavtornameSearch represents the model behind the search form of `\app\core\models\Libavtorname`.
 */
class LibavtornameSearch extends Libavtorname
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AvtorId', 'uid', 'MasterId'], 'integer'],
            [['FirstName', 'MiddleName', 'LastName', 'NickName', 'Email', 'Homepage', 'Gender'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Libavtorname::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'AvtorId' => $this->AvtorId,
            'uid' => $this->uid,
            'MasterId' => $this->MasterId,
        ]);

        $query->andFilterWhere(['like', 'FirstName', $this->FirstName])
            ->andFilterWhere(['like', 'MiddleName', $this->MiddleName])
            ->andFilterWhere(['like', 'LastName', $this->LastName])
            ->andFilterWhere(['like', 'NickName', $this->NickName])
            ->andFilterWhere(['like', 'Email', $this->Email])
            ->andFilterWhere(['like', 'Homepage', $this->Homepage])
            ->andFilterWhere(['like', 'Gender', $this->Gender]);

        return $dataProvider;
    }
}
