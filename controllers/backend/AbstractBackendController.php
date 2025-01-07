<?php declare(strict_types=1);

namespace app\controllers\backend;

use app\controllers\AbstractController;
use yii\filters\AccessControl;

abstract class AbstractBackendController extends AbstractController
{
    public function behaviors(): array
    {
        $this->layout = 'backend';

        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}