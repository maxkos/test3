<?php

use app\models\ShortUrl;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/** @var View $this */
/** @var ShortUrl $model */
?>
<div class="card m-1">
    <div class="row g-0">
        <div class="col-md-3">
            <?php echo Html::img(['/short-url/qr', 'id' => $model->id], ['class' => 'figure-img img-fluid rounded', 'alt' => $model->getFullShortUrl()]); ?>
        </div>
        <div class="col-md-9">
            <div class="card-body">
                <?php echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        [
                            'attribute' => 'url',
                            'format' => 'raw',
                            'value' => function (ShortUrl $model) {
                                return Html::tag('div', Html::a($model->url, $model->url, ['target' => '_blank']), ['class' => 'text-break']);
                            },
                        ],
                        [
                            'attribute' => 'short',
                            'format' => 'raw',
                            'value' => function (ShortUrl $model) {
                                return Html::a($model->short, $model->getFullShortUrl(), ['target' => '_blank']);
                            },
                        ],
                        [
                            'label' => 'Короткая ссылка',
                            'format' => 'raw',
                            'value' => function (ShortUrl $model) {
                                return Html::a($model->getFullShortUrl(), $model->getFullShortUrl(), ['target' => '_blank']);
                            },
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function (ShortUrl $model) {
                                return Html::renderLabel($model->statusName, $model->statusStyle);
                            },
                        ],
                        [
                            'attribute' => 'created_at',
                            'format' => 'raw',
                            'value' => function (ShortUrl $model) {
                                return Yii::$app->formatter->asDate($model->created_at, 'php: d.m.Y H:i:s');
                            },

                        ],
                        'hits',
                    ],
                ]) ?>            </div>
        </div>
    </div>
</div>