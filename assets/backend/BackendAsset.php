<?php declare(strict_types=1);

namespace app\assets\backend;

use yii\web\AssetBundle;

class BackendAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/backend/static';

    /** @var string[] */
    public $js = [
        'js/backend.js',
    ];

    /** @var string[] */
    public $css = [
        'css/backend.css',
    ];

    /** @var string[] */
    public $depends = [];
}