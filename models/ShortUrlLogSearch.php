<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ShortUrlLog;

/**
 * ShortUrlLogSearch represents the model behind the search form of `app\models\ShortUrlLog`.
 */
class ShortUrlLogSearch extends ShortUrlLog
{
    /**
     * @var string|null
     */
    public ?string $short_url = null;

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            ['short_url', 'trim'],
            [['id', 'short_url_id'], 'integer'],
            [['ip', 'user_agent', 'created_at', 'short_url'], 'safe'],
        ];
    }

    /**
     * @return array|array[]
     */
    public function scenarios(): array
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
        $query = ShortUrlLog::find()->alias('sul')->joinWith('shortUrl su');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'created_at',
                    'id' => [
                        'asc' => ['sul.id' => SORT_ASC],
                        'desc' => ['sul.id' => SORT_DESC],
                    ],
                    'user_agent' => [
                        'asc' => ['sul.user_agent' => SORT_ASC],
                        'desc' => ['sul.user_agent' => SORT_DESC],
                    ],
                    'ip' => [
                        'asc' => ['sul.ip' => SORT_ASC],
                        'desc' => ['sul.ip' => SORT_DESC],
                    ],
                    'created_at' => [
                        'asc' => ['sul.created_at' => SORT_ASC],
                        'desc' => ['sul.created_at' => SORT_DESC],
                    ],
                    'short_url' => [
                        'asc' => ['su.url' => SORT_ASC],
                        'desc' => ['su.url' => SORT_DESC],
                    ],
                    'short_url_id' => [
                        'asc' => ['sul.short_url_id' => SORT_ASC],
                        'desc' => ['sul.short_url_id' => SORT_DESC],
                    ],
                ],
            ],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if ($this->short_url !== null && $this->short_url != '') {
            $query->andFilterWhere(['like', 'su.url', $this->short_url]);
        }

        $query->andFilterWhere([
            'sul.id' => $this->id,
            'sul.short_url_id' => $this->short_url_id,
            'sul.created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'sul.ip', $this->ip])
            ->andFilterWhere(['like', 'sul.user_agent', $this->user_agent]);

        return $dataProvider;
    }
}
