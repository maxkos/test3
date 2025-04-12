<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ShortUrl]].
 *
 * @see ShortUrl
 */
class ShortUrlQuery extends ActiveQuery
{
    /**
     * @return ShortUrlQuery
     */
    public function active(): ShortUrlQuery
    {
        return $this->andWhere(['status' => ShortUrl::STATUS__ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @return ShortUrl[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ShortUrl|array|null
     */
    public function one($db = null): ShortUrl|array|null
    {
        return parent::one($db);
    }
}
