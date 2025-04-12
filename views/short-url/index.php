<?php

use app\models\ShortUrl;
use app\models\ShortUrlSearch;
use kartik\dynagrid\DynaGrid;
use kartik\grid\ActionColumn;
use kartik\grid\ExpandRowColumn;
use kartik\grid\GridView;
use kartik\grid\GridViewInterface;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var View $this */
/** @var ShortUrlSearch $searchModel */
/** @var ActiveDataProvider $dataProvider */

$this->title = 'Ссылки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="short-url-index">

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
            'vAlign' => 'middle',
            'hAlign' => 'center',
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function (ShortUrl $model) {
                return Html::renderLabel($model->getStatusName(), $model->getStatusStyle());
            },
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'filter' => ShortUrl::getStatusList(),
        ],
        [
            'class' => ActionColumn::class,
            'template' => '{view} {delete}',
            'viewOptions' => ['label' => '<i class="fas fa-eye"></i>', 'class' => 'btn btn-info btn-rounded btn-condensed btn-sm',],
            'deleteOptions' => ['label' => '<i class="fas fa-times"></i>', 'class' => 'btn btn-danger btn-rounded btn-condensed btn-sm', 'message' => 'Вы действительно хотите удалить эту запись?',],
            'urlCreator' => function ($action, ShortUrl $model, $key, $index, $column) {
                return Url::toRoute(['/short-url/' . $action, 'id' => $model->id,]);
            },
        ],
        [
            'class' => ExpandRowColumn::class,
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridViewInterface::ROW_COLLAPSED;
            },
            'detailUrl' => Url::to('/short-url/detail'),
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true
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
                'heading' => '<h3 class="panel-title"><i class="fas fa-list-alt"></i> Таблица данных</h3>',
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
            'id' => 'short-url-index',
        ]
    ]);
    ?>


</div>
