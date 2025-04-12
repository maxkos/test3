<?php

namespace app\components;

use Yii;
use yii\helpers\HtmlPurifier;
use yii\web\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @param string $message
     * @param bool $append
     * @param bool $removeAfterAccess
     */
    public function setSuccessFlash(string $message, bool $append = false, bool $removeAfterAccess = true): void
    {
        $this->setFlash('success', $message, $append, $removeAfterAccess);
    }

    /**
     * @param string $message
     * @param bool $append
     * @param bool $removeAfterAccess
     */
    public function setWarningFlash(string $message, bool $append = false, bool $removeAfterAccess = true): void
    {
        $this->setFlash('warning', $message, $append, $removeAfterAccess);
    }

    /**
     * @param string $message
     * @param bool $append
     * @param bool $removeAfterAccess
     */
    public function setFailureFlash(string $message, bool $append = false, bool $removeAfterAccess = true): void
    {
        $this->setFlash('error', $message, $append, $removeAfterAccess);
    }

    /**
     * @param string $message
     * @param bool $append
     * @param bool $removeAfterAccess
     */
    public function setInfoFlash(string $message, bool $append = false, bool $removeAfterAccess = true): void
    {
        $this->setFlash('info', $message, $append, $removeAfterAccess);
    }

    /**
     * @param string $key
     * @param string $message
     * @param bool $append
     * @param bool $removeAfterAccess
     */
    public function setFlash(string $key, string $message, bool $append = false, bool $removeAfterAccess = true): void
    {
        $message = HtmlPurifier::process($message);

        if ($append)
            Yii::$app->getSession()->addFlash($key, $message, $removeAfterAccess);
        else
            Yii::$app->getSession()->setFlash($key, $message, $removeAfterAccess);
    }
}