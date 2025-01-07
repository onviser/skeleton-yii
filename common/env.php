<?php declare(strict_types=1);

use app\common\EnvVariable\EnvVariable;

$data = file_get_contents(__DIR__ . '/../.env');
$env = new EnvVariable($data === false ? '' : $data);

function env(string $name, string $defaultValue = ''): string
{
    $value = getenv($name);
    return $value === false ? $defaultValue : $value;
}

$yiiDebug = env('YII_DEBUG');
$yiiEnv = env('YII_ENV');
defined('YII_DEBUG') or define('YII_DEBUG', in_array($yiiDebug, ['0', '1', 'true', 'false']) ? boolval($yiiDebug) : false);
defined('YII_ENV') or define('YII_ENV', in_array($yiiEnv, ['prod', 'dev', 'test']) ? $yiiEnv : 'prod');