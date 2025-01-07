<?php declare(strict_types=1);

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id'                  => 'basic-console',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'app\commands',
    'components'          => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log'          => [
            'targets' => [
                'dbError' => [
                    'class'   => 'yii\log\DbTarget',
                    'levels'  => ['error', 'warning'],
                    'except'  => [],
                    'prefix'  => function () {
                        $url = Yii::$app->request->isConsoleRequest
                            ? 'console'
                            : Yii::$app->request->getUrl();
                        $userId = Yii::$app->user?->identity?->getId() ?? 0;
                        return sprintf('[%s][%s]', $url, $userId);
                    },
                    'logVars' => []
                ],
                'dbInfo'  => [
                    'class'   => 'yii\log\DbTarget',
                    'levels'  => ['info'],
                    'except'  => [
                        'yii\db\*',
                        'yii\web\*',
                    ],
                    'prefix'  => function () {
                        $url = Yii::$app->request->isConsoleRequest
                            ? 'console'
                            : Yii::$app->request->getUrl();
                        $userId = Yii::$app->user?->identity?->getId() ?? 0;
                        return sprintf('[%s][%s]', $url, $userId);
                    },
                    'logVars' => []
                ],
            ],
        ],
        'db'    => $db,
    ],
    'params'              => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
