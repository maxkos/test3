<?php

use app\models\ShortUrlLog;
use app\models\ShortUrlLogSearch;
use kartik\dynagrid\DynaGrid;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/** @var View $this */
/** @var ShortUrlLogSearch $searchModel */
/** @var ActiveDataProvider $dataProvider */

$this->title = 'Лог переходов по ссылке';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="short-url-log-index">

    <?php
    $columns = [
        [
            'class' => SerialColumn::class,
            'order' => DynaGrid::ORDER_FIX_LEFT
        ],
        [
            'attribute' => 'id',
            'width' => '50px',
            'vAlign' => 'middle',
            'hAlign' => 'center',
        ],
        [
            'attribute' => 'short_url_id',
            'format' => 'raw',
            'value' => function (ShortUrlLog $model) {
                return Html::a($model->short_url_id, ['/short-url/view', 'id' => $model->short_url_id]);
            },
            'vAlign' => 'middle',
            'hAlign' => 'center',
        ],
        [
            'attribute' => 'short_url',
            'format' => 'raw',
            'value' => function (ShortUrlLog $model) {
                return Html::a($model->shortUrl->url, $model->shortUrl->url, ['target' => '_blank']);
            },
        ],
        [
            'attribute' => 'ip',
            'vAlign' => 'middle',
            'hAlign' => 'center',
        ],
        'user_agent:ntext',
        [
            'attribute' => 'created_at',
            'format' => 'raw',
            'value' => function (ShortUrlLog $model) {
                return Yii::$app->formatter->asDate($model->created_at, 'php: d.m.Y H:i:s');
            },
            'vAlign' => 'middle',
            'hAlign' => 'center',
        ],
    ];
    echo DynaGrid::widget([
        'columns' => $columns,
        'theme' => 'panel-primary',
        'storage' => DynaGrid::TYPE_COOKIE,
        'showPersonalize' => true,
        'allowThemeSetting' => false,
        'gridOptions' => [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'bordered' => true,
            'condensed' => true,
            'responsiveWrap' => true,
            'showPageSummary' => false,
            'floatHeader' => false,
            'headerContainer' => ['class' => 'kv-table-header', 'style' => 'top: 50px'],
            'pjax' => true,
            'panel' => [
                'heading' => '<h3 class="panel-title"><i class="fas fa-list-alt"></i>  Таблица данных</h3>',
                'before' => '',
                'after' => false
            ],
            'toolbar' => [
                [
                    'content' => '{dynagridFilter}{dynagridSort}{dynagrid}' . Html::a('<i class="fas fa-redo"></i>', [
                            'index',
                            'reset' => 1,
                        ], [
                            'data-pjax' => 0,
                            'class' => 'btn btn-outline-secondary',
                            'title' => 'Сброс',
                        ]),
                ],
                '{export}',
                '{toggleData}',
            ]
        ],
        'options' => [
            'id' => 'short-url-log-index',
        ]
    ]);
    ?>


</div>
