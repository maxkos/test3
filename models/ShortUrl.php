<?php

namespace app\models;

use app\traits\EnumToArray;
use app\traits\EnumTrait;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%short_url}}".
 *
 * @property int $id
 * @property string $url
 * @property string $short
 * @property int $status
 * @property string $created_at
 * @property int $hits
 *
 * @property string $statusName
 * @property string $statusStyle
 */
class ShortUrl extends ActiveRecord
{
    use EnumTrait;

    const STATUS__INACTIVE = 0;

    const STATUS__ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%short_url}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['status'], 'default', 'value' => self::STATUS__ACTIVE],
            [['hits'], 'default', 'value' => 0],
            [['url', 'short'], 'required'],
            [['url'], 'string'],
            [['hits'], 'integer'],
            [['created_at'], 'safe'],
            [['short'], 'string', 'max' => 48],
            [['short'], 'unique'],
            ['status', 'in', 'range' => self::getConstants('STATUS__'),],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'url' => 'URL',
            'short' => 'Хэш ссылки',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'hits' => 'Кол-во переходов',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ShortUrlQuery the active query used by this AR class.
     */
    public static function find(): ShortUrlQuery
    {
        return new ShortUrlQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::STATUS__INACTIVE => 'Заблоктрован',
            self::STATUS__ACTIVE => 'Активен',
        ];
    }

    /**
     * @return string
     */
    public function getStatusName(): string
    {
        $list = self::getStatusList();

        return array_key_exists($this->status, $list) ? $list[$this->status] : 'Не определен';
    }

    /**
     *
     * @return array
     */
    public static function getStatusStyleList(): array
    {
        return [
            self::STATUS__INACTIVE => 'danger',
            self::STATUS__ACTIVE => 'success',
        ];
    }

    /**
     * @return string
     */
    public function getStatusStyle(): string
    {
        $list = self::getStatusStyleList();

        return array_key_exists($this->status, $list) ? $list[$this->status] : 'default';
    }

    /**
     * @param string $short
     * @param int $status
     * @return ShortUrl|null
     */
    public static function findByShort(string $short, int $status = self::STATUS__ACTIVE): ?ShortUrl
    {
        return static::findOne(['short' => $short, 'status' => $status]);
    }

    /**
     * @return string
     */
    public function getFullShortUrl(): string
    {
        return Url::to(Url::to(['/site/redirect', 'short' => $this->short], true));
    }

}
