<?php

namespace app\controllers;

use app\models\ShortUrl;
use app\models\ShortUrlSearch;
use Da\QrCode\Component\QrCodeComponent;
use Yii;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\Session;

/**
 * ShortUrlController implements the CRUD actions for ShortUrl model.
 */
class ShortUrlController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * @return string|Response
     */
    public function actionIndex(): Response|string
    {
        $searchModel = new ShortUrlSearch();

        /** @var Session $session */
        $session = Yii::$app->session;
        $params = Yii::$app->request->queryParams;
        $reset = (int)$this->request->get('reset', false);
        unset($params['reset']);
        if (empty($params)) {
            $params = $session->get('short-url-list-index');
            if (is_array($params) && array_key_exists('page', $params))
                $_GET['page'] = $params['page'];
            if (is_array($params) && array_key_exists('sort', $params))
                $_GET['sort'] = $params['sort'];
        } else {
            $session->set('short-url-list-index', $params);
        }

        if ($reset)
            return $this->redirect(['/short-url/index']);

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShortUrl model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \Da\QrCode\Exception\BadMethodCallException
     * @throws \Da\QrCode\Exception\ValidationException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionQr($id): string
    {
        $model = $this->findModel($id);

        /** @var QrCodeComponent $qr */
        $qr = Yii::$app->get('qr');
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', $qr->getContentType());
        return $qr->setText($model->getFullShortUrl())->writeString();
    }

    /**
     * Deletes an existing ShortUrl model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id): Response
    {
        $deleteItem = $this->findModel($id)->delete();
        if ($deleteItem === false)
            $this->setFailureFlash('Ошибка удаления ссылки.');
        elseif ($deleteItem > 0)
            $this->setSuccessFlash('Ссылка успешно удалена.');
        else
            $this->setWarningFlash('Ссылки не была удалена.');

        return $this->redirect(['index']);
    }

    /**
     * Finds the ShortUrl model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ShortUrl the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): ShortUrl
    {
        if (($model = ShortUrl::findOne(['id' => $id])) !== null)
            return $model;

        throw new NotFoundHttpException('Запрашиваемая ссылка не найдена');
    }

    /**
     * Render ajax request for detail
     *
     * @return string
     */
    public function actionDetail(): string
    {
        if (!empty($this->request->post('expandRowKey'))) {
            $model = $this->findModel($_POST['expandRowKey']);
            return $this->renderPartial('blocks/_details', ['model' => $model]);
        } else
            return '<div class="alert alert-danger">Запрашиваемая ссылка не найдена.</div>';
    }
}
