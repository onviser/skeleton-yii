<?php declare(strict_types=1);

namespace app\controllers\backend;

use Yii;

class DashboardController extends AbstractBackendController
{
    public function actionIndex(): string
    {
        return $this->render('/backend/dashboard', [
            'user' => Yii::$app->user->identity
        ]);
    }
}