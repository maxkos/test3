<?php

namespace app\controllers;

use app\models\ShortUrl;
use app\models\ShortUrlForm;
use app\models\ShortUrlLog;
use kartik\form\ActiveForm;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SiteController extends Controller
{

    /**
     * @return array[]
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string|array
     * @throws BadRequestHttpException
     */
    public function actionIndex(): string|array
    {

        $shortUrlForm = new ShortUrlForm();
        $shortUrl = null;
        if ($this->request->isPost && $shortUrlForm->load($this->request->post()) && $shortUrlForm->validate()) {
            if ($this->request->isAjax && !$this->request->isPjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
            }
//            try {
                if ($shortUrlForm->save()) {
                    $shortUrl = $shortUrlForm->getShortUrlModel();
                } else {
                    throw new BadRequestHttpException('Ошибка сохранения');
                }
                if ($this->request->isAjax && !$this->request->isPjax) {
                    return ['success' => true, 'htmlShortUrl' => $this->renderAjax('blocks/_short-url', ['shortUrl' => $shortUrl])];
                }

//            } catch (\Throwable $exception) {
//                throw new BadRequestHttpException('Ошибка генерации короткой ссылки');
//            }
        }
        return $this->render('index', ['shortUrlForm' => $shortUrlForm, 'shortUrl' => $shortUrl]);
    }

    /**
     * @param $short
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionRedirect($short): Response
    {
        if (!($shortUrl = ShortUrl::findByShort($short)))
            throw new NotFoundHttpException('Запрашиваемая ссылка не найдена');
        try {
            $shortUrl->updateCounters(['hits' => 1]);
            if (!(new ShortUrlLog([
                'short_url_id' => $shortUrl->id,
                'ip' => $this->request->getUserIP(),
                'user_agent' => $this->request->getUserAgent(),
            ]))->save())
                throw new BadRequestHttpException('Short URL log is not save');
        } catch (\Throwable $exception) {

        }

        return $this->redirect($shortUrl->url);
    }

    /**
     * @return array|Response
     */
    public function actionShortUrlValidate(): Response|array
    {
        $shortUrlForm = new ShortUrlForm();
        if ($this->request->isAjax && $shortUrlForm->load($this->request->post())) {
            $this->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($shortUrlForm);
        } else {
            return $this->redirect(['index']);
        }
    }
}
