<?php

namespace app\models;

use app\components\hash\GeneratorInterface;
use GuzzleHttp\Psr7\Request;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\Exception;
use yii\di\NotInstantiableException;
use yii\web\BadRequestHttpException;

class ShortUrlForm extends Model
{


    public function __construct($config = [])
    {
        parent::__construct($config);

    }

    /**
     * @var string|null
     */
    public ?string $url = null;

    /**
     * @var ShortUrl|null
     */
    protected ?ShortUrl $shortUrlModel = null;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['url'], 'trim'],
            [['url'], 'required'],
            [['url'], 'url'],
            ['url', 'checkUrlStatus'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'url' => 'URL'
        ];
    }

    /**
     * @param string $attribute
     * @param array|null $params
     */
    public function checkUrlStatus(string $attribute, ?array $params = []): void
    {
        if (!$this->hasErrors()) {
            stream_context_set_default([
                //Отключаем валидацию SSL сертификата
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
                //Запрашиваем только заголовок
                'http' => [
                    'method' => 'HEAD'
                ]
            ]);

            $urlHeaders = @get_headers($this->$attribute);

            if (empty($urlHeaders[0])
                || (preg_match('#HTTP/\d+\.\d+ (?P<http_code>\d{3})#', $urlHeaders[0], $matches) !== 1)
                || !in_array($matches['http_code'], \Yii::$app->params['goodStatusCode'])) {
                $this->addError($attribute, 'Указанная ссылка не действительна');
            }

        }
    }

    /**
     * @return string
     * @throws ShortUrlException
     */
    protected function generateShort(): string
    {
        try {
            /** @var GeneratorInterface $hashGenerator */
            $hashGenerator = \Yii::$container->get('HashGenerator');
            return $hashGenerator->generate($this->url);
        } catch (NotInstantiableException|InvalidConfigException $e) {
            throw new ShortUrlException('Short URL is not generated.');
        }
    }

    /**
     * @return bool
     * @throws Exception
     * @throws ShortUrlException
     */
    public function save(): bool
    {
        $short = $this->generateShort();
        //Check exist ShortUrl by short alias
        if (($findByShort = ShortUrl::find()->where(['short' => $short])->one())) {
            if ($findByShort->url !== $this->url || $findByShort->status === ShortUrl::STATUS__INACTIVE) {
                $iteration = 0;
                while (ShortUrl::find()->where(['short' => $short, 'url' => $this->url])->exists()) {
                    $iteration++;
                    $short = $short . $iteration;
                }
            } else {
                $this->shortUrlModel = $findByShort;
                return true;
            }
        }

        $this->shortUrlModel = new ShortUrl([
            'url' => $this->url,
            'short' => $this->generateShort(),
            'status' => ShortUrl::STATUS__ACTIVE
        ]);

        if (!$this->shortUrlModel->save()) {
            throw new ShortUrlException('Short URL is not saved');
        }
        return true;
    }

    /**
     * @return ShortUrl|null
     */
    public function getShortUrlModel(): ?ShortUrl
    {
        return $this->shortUrlModel;
    }

}