<?php

use app\models\ShortUrl;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/** @var View $this */
/** @var ShortUrl $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ссылки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="short-url-view">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить запись?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

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
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function (ShortUrl $model) {
                    return Html::renderLabel($model->getStatusName(), $model->getStatusStyle());
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
    ]) ?>

</div>
