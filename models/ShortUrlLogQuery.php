<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ShortUrlLog]].
 *
 * @see ShortUrlLog
 */
class ShortUrlLogQuery extends ActiveQuery
{

    /**
     * {@inheritdoc}
     * @return ShortUrlLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ShortUrlLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
