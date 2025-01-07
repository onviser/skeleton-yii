<?php declare(strict_types=1);

namespace app\controllers\frontend;

use app\common\Captcha\CaptchaGenerator;
use app\models\blocker\BlockerIp;
use app\models\ContactForm;
use Yii;
use yii\db\Exception;
use yii\web\Response;

class ContactController extends AbstractFrontendController
{
    /**
     * @throws Exception
     */
    public function actionIndex(): Response|string
    {
        $session = Yii::$app->getSession();
        $session->open();

        $model = new ContactForm();

        $request = Yii::$app->request;
        $isIpValid = !$request->isPost || BlockerIp::check(
                BlockerIp::getIpFromHeaders($_SERVER), // taking the IP from the headers
                BlockerIp::ACTION_FEEDBACK, // what kind of action we are blocking
                BlockerIp::MINUTE_FEEDBACK, // for how many minutes we block
                BlockerIp::ATTEMPT_FEEDBACK // after how many attempts
            );
        if ($isIpValid === false) {
            $model->addError('verifyCode', 'The number of attempts has been exceeded, wait a few minutes.');
        }

        if ($model->load(Yii::$app->request->post()) && $isIpValid && $model->contact(Yii::$app->params['adminEmail'])) {
            $session->remove(CaptchaGenerator::SESSION_KEY);
            Yii::$app->session->setFlash('contactFormSubmitted');
        }
        return $this->render('/frontend/contact', [
            'model' => $model,
        ]);
    }
}