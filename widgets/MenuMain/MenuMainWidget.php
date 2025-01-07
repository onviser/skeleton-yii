<?php declare(strict_types=1);

namespace app\widgets\MenuMain;

use Yii;
use yii\base\Widget;

class MenuMainWidget extends Widget
{
    public string $view = 'index';

    public function run(): string
    {
        $menu = [
            '/'        => 'Main',
            '/about'   => 'About',
            '/contact' => 'Contact',
        ];

        $user = Yii::$app->user->identity;
        if ($user) {
            $menu['/admin/'] = 'Dashboard';
            $menu['/admin/log/'] = 'Log';
            $menu['/logout'] = 'Logout';
        } else {
            $menu['/login'] = 'Login';
        }

        return $this->render($this->view, [
            'menu' => $menu
        ]);
    }
}