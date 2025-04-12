<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%short_url_log}}".
 *
 * @property int $id
 * @property int $short_url_id
 * @property string $ip
 * @property string|null $user_agent
 * @property string $created_at
 *
 * @property ShortUrl $shortUrl
 */
class ShortUrlLog extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%short_url_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_agent'], 'default', 'value' => null],
            [['short_url_id', 'ip'], 'required'],
            [['short_url_id'], 'integer'],
            [['user_agent'], 'string'],
            [['created_at'], 'safe'],
            [['ip'], 'string', 'max' => 15],
            [['short_url_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShortUrl::class, 'targetAttribute' => ['short_url_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'short_url_id' => 'URL',
            'ip' => 'IP',
            'user_agent' => 'User Agent',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * Gets query for [[ShortUrl]].
     *
     * @return ActiveQuery
     */
    public function getShortUrl()
    {
        return $this->hasOne(ShortUrl::class, ['id' => 'short_url_id']);
    }

    /**
     * {@inheritdoc}
     * @return ShortUrlLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShortUrlLogQuery(get_called_class());
    }

}
