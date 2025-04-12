<?php

use app\models\ShortUrl;
use yii\bootstrap5\Html;
use yii\web\View;

/** @var View $this */
/** @var ShortUrl $shortUrl */
?>
<div class="short-url-detail">
    <?php if ($shortUrl): ?>
        <figure class="figure">
            <figcaption
                    class="figure-caption text-center"><?php echo Html::a($shortUrl->getFullShortUrl(), $shortUrl->getFullShortUrl(), ['target' => '_blank', 'data-pjax' => '0']); ?></figcaption>
            <?php echo Html::img(['/short-url/qr', 'id' => $shortUrl->id], ['class' => 'figure-img img-fluid rounded', 'alt' => $shortUrl->getFullShortUrl()]); ?>
        </figure>
    <?php endif; ?>
</div>
