<?php declare(strict_types=1);

use yii\symfonymailer\Mailer;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id'         => 'basic',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset'
    ],
    'components' => [
        'session'      => [
            'class'        => 'yii\web\DbSession',
            'db'           => 'db',
            'sessionTable' => 'session',
        ],
        'request'      => [
            'cookieValidationKey' => env('COOKIE_VALIDATION_KEY'),
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl'        => ['/login']
        ],
        'errorHandler' => [
            'errorAction' => 'frontend/error/index',
        ],
        'mailer'       => [
            'class'            => Mailer::class,
            'viewPath'         => '@app/mail',
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'class'           => 'yii\web\AssetManager',
            'appendTimestamp' => true,
            'linkAssets'      => true,
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
        'db'           => $db,
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                // frontend
                ['pattern' => '', 'route' => 'frontend/index/index', 'suffix' => ''],
                ['pattern' => 'about', 'route' => 'frontend/about/index', 'suffix' => ''],
                ['pattern' => 'contact', 'route' => 'frontend/contact/index', 'suffix' => ''],
                ['pattern' => 'login', 'route' => 'frontend/login/index', 'suffix' => ''],
                ['pattern' => 'logout', 'route' => 'frontend/logout/index', 'suffix' => ''],

                // backend
                ['pattern' => 'admin', 'route' => 'backend/dashboard/index', 'suffix' => '/'],
                ['pattern' => 'admin/log', 'route' => 'backend/log/index', 'suffix' => '/']
            ],
        ],
    ],
    'params'     => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class'      => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.65.1']
    ];
}

return $config;
