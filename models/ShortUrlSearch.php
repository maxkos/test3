<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ShortUrl;

/**
 * ShortUrlSearch represents the model behind the search form of `app\models\ShortUrl`.
 */
class ShortUrlSearch extends ShortUrl
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['id', 'status', 'hits'], 'integer'],
            [['url', 'short', 'created_at'], 'safe'],
        ];
    }

    /**
     * @return array|array[]
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array|null $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search(?array $params, string $formName = null): ActiveDataProvider
    {
        $query = ShortUrl::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'hits' => $this->hits,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'short', $this->short]);

        return $dataProvider;
    }
}
