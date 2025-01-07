<?php declare(strict_types=1);

namespace app\controllers\frontend;

class IndexController extends AbstractFrontendController
{
    public function actionIndex(): string
    {
        return $this->render('/frontend/index');
    }
}
