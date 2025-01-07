<?php declare(strict_types=1);

namespace app\controllers\frontend;

use Yii;
use yii\filters\AccessControl;
use yii\web\Response;

class LogoutController extends AbstractFrontendController
{
    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ]);
    }

    public function actionIndex(): Response
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}