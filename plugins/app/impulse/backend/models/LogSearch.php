<?php

namespace app\impulse\backend\models;

use app\impulse\models\Log;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LogSearch represents the model behind the search form about `\app\impulse\models\Log`.
 */
class LogSearch extends Log
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'level'], 'integer'],
            [['category', 'message', 'ip', 'url', 'created_at'], 'safe'],
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
        $query = Log::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $dates = preg_split('/[\s-]+/', $this->created_at, null, PREG_SPLIT_NO_EMPTY);

        if ($dates) {
            if (count($dates) === 1) {
                $dates[1] = $dates[0];
            }

            $query->andWhere(['between', 'created_at', date_format(date_create_from_format('d.m.Y', $dates[0]), 'Y-m-d 00:00:00'), date_format(date_create_from_format('d.m.Y', $dates[1]), 'Y-m-d 23:59:59')]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'level' => $this->level,
        ]);

        $query
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
