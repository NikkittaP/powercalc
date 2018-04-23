<?php

use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
?>

<?= Highcharts::widget([
    'scripts' => [
        'modules/exporting',
        'themes/avocado',
    ],
    'options' => [
        'credits' => ['enabled' => false],
        'chart'=>[
            //'height'=>  500,
            //'width' => 1000,
            'style' => [
                //'fontFamily' => 'Arial',
            ],
        ],
        'title' => [
            'text' => 'Сравнение архитектур по потреблению',
        ],
        'xAxis' => [
            'title' => [
                'text' => 'Режимы полёта',
            ],
            'categories' => ['Взлёт', 'Крейсер', 'Посадка', 'Руление']
        ],
        'yAxis' => [
            'title' => [
                'text' => 'Потребление',
            ],
        ],
        'plotOptions' => [
            'column' => [
                'borderRadius' => 5,
            ],
        ],
        'series' => [
            [
                'type' => 'column',
                'name' => 'База',
                'data' => [10, 50, 37, 50],
            ],
            [
                'type' => 'column',
                'name' => 'БЭС1',
                'data' => [12, 56, 0, 44],
            ],
            [
                'type' => 'column',
                'name' => 'Архит. 6 2H2E',
                'data' => [0, 4, 2, 70],
            ],
            [
                'type' => 'spline',
                'name' => 'Располагаемый расход',
                'data' => [90, 90, 80, 40],
                'marker' => [
                    'lineWidth' => 2,
                    'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
                    'fillColor' => 'white',
                ],
            ],
        ]
    ]
    ]);
?>