<?php

use app\models\ShortUrl;
use app\models\ShortUrlForm;
use kartik\form\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/** @var View $this */
/** @var ShortUrlForm $shortUrlForm */
/** @var ShortUrl $shortUrl */

$this->title = 'Генератор коротких ссылок c QR-кодом';
?>
<div class="site-index">
    <?php echo $this->render('blocks/_pjax-form', ['shortUrlForm' => $shortUrlForm, 'shortUrl' => $shortUrl]); ?>
    <?php echo $this->render('blocks/_ajax-form', ['shortUrlForm' => $shortUrlForm, 'shortUrl' => $shortUrl]); ?>
</div>
