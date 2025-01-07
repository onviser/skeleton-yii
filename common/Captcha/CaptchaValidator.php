<?php declare(strict_types=1);

namespace app\common\Captcha;

use Yii;
use yii\validators\Validator;

class CaptchaValidator extends Validator
{
    public function validateAttribute($model, $attribute): void
    {
        $valueFromSession = trim(strval(Yii::$app->session->get('captcha', '')));
        if (mb_strtolower($valueFromSession) !== mb_strtolower($model->$attribute)) {
            $this->addError($model, $attribute, 'The verification code is incorrect');
        }
    }
}