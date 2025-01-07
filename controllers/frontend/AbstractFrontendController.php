<?php declare(strict_types=1);

namespace app\controllers\frontend;

use app\controllers\AbstractController;
use yii\filters\AccessControl;

class AbstractFrontendController extends AbstractController
{
    public function behaviors(): array
    {
        $this->layout = 'frontend';

        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }
}