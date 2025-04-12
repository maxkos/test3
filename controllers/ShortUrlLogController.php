<?php

namespace app\controllers;

use app\components\Controller;
use app\models\ShortUrlLogSearch;
use Yii;
use yii\web\Response;

/**
 * ShortUrlLogController implements the CRUD actions for ShortUrlLog model.
 */
class ShortUrlLogController extends Controller
{

    /**
     * @return string|Response
     */
    public function actionIndex(): Response|string
    {
        $searchModel = new ShortUrlLogSearch();
        $session = Yii::$app->getSession();
        $params = Yii::$app->request->queryParams;
        $reset = (int)$this->request->get('reset', false);
        unset($params['reset']);
        if (empty($params)) {
            $params = $session->get('short-url-log-list-index');
            if (is_array($params) && array_key_exists('page', $params))
                $_GET['page'] = $params['page'];
            if (is_array($params) && array_key_exists('sort', $params))
                $_GET['sort'] = $params['sort'];
        } else {
            $session->set('short-url-log-list-index', $params);
        }

        if ($reset)
            return $this->redirect(['/short-url-log/index']);

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
