<?php declare(strict_types=1);

namespace app\controllers\frontend;

use app\models\blocker\BlockerIp;
use app\models\LoginForm;
use Yii;
use yii\db\Exception;
use yii\web\Response;

class LoginController extends AbstractFrontendController
{
    /**
     * @throws Exception
     */
    public function actionIndex(): Response|string
    {
        if (Yii::$app->user->isGuest === false) {
            return $this->goHome();
        }

        $model = new LoginForm();

        $request = Yii::$app->request;
        $isIpValid = !$request->isPost || BlockerIp::check(
                BlockerIp::getIpFromHeaders($_SERVER), // taking the IP from the headers
                BlockerIp::ACTION_LOGIN, // what kind of action we are blocking
                BlockerIp::MINUTE_LOGIN, // for how many minutes we block
                BlockerIp::ATTEMPT_LOGIN // after how many attempts
            );
        if ($isIpValid === false) {
            $model->addError('password', 'The number of attempts has been exceeded, wait a few minutes.');
        }

        if ($model->load(Yii::$app->request->post()) && $isIpValid && $model->login()) {
            return $this->goBack();
        }
        $model->password = '';
        return $this->render('/frontend/login', [
            'model' => $model,
        ]);
    }
}