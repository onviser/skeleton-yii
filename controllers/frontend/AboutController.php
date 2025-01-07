<?php declare(strict_types=1);

namespace app\controllers\frontend;

use yii\filters\AccessControl;

class AboutController extends AbstractFrontendController
{
    public function actionIndex(): string
    {
        return $this->render('/frontend/about');
    }
}