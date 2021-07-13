<?php

namespace app\core\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\core\models\Libbook;

/**
 * LibbookSearch represents the model behind the search form of `app\core\models\Libbook`.
 */
class LibbookSearch extends Libbook
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['BookId', 'FileSize', 'LangEx', 'Year', 'N', 'InfoCode', 'Pages', 'Chars'], 'integer'],
            [['Time', 'Title', 'Title1', 'Lang', 'SrcLang', 'FileType', 'Encoding', 'Deleted', 'Ver', 'FileAuthor', 'keywords', 'md5', 'Modified', 'pmd5'], 'safe'],
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
        $query = Libbook::find();

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
            'BookId' => $this->BookId,
            'FileSize' => $this->FileSize,
            'Time' => $this->Time,
            'LangEx' => $this->LangEx,
            'Year' => $this->Year,
            'N' => $this->N,
            'Modified' => $this->Modified,
            'InfoCode' => $this->InfoCode,
            'Pages' => $this->Pages,
            'Chars' => $this->Chars,
        ]);

        $query->andFilterWhere(['like', 'Title', $this->Title])
            ->andFilterWhere(['like', 'Title1', $this->Title1])
            ->andFilterWhere(['like', 'Lang', $this->Lang])
            ->andFilterWhere(['like', 'SrcLang', $this->SrcLang])
            ->andFilterWhere(['like', 'FileType', $this->FileType])
            ->andFilterWhere(['like', 'Encoding', $this->Encoding])
            ->andFilterWhere(['like', 'Deleted', $this->Deleted])
            ->andFilterWhere(['like', 'Ver', $this->Ver])
            ->andFilterWhere(['like', 'FileAuthor', $this->FileAuthor])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'md5', $this->md5])
            ->andFilterWhere(['like', 'pmd5', $this->pmd5]);

        return $dataProvider;
    }
}
