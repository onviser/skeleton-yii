<?php declare(strict_types=1);

namespace app\assets\frontend;

use yii\web\AssetBundle;

class FrontendAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/frontend/static';

    /** @var string[] */
    public $js = [
        'js/frontend.js',
    ];

    /** @var string[] */
    public $css = [
        'css/frontend.css',
    ];

    /** @var string[] */
    public $depends = [];
}