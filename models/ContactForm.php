<?php declare(strict_types=1);

namespace app\models;

use app\common\Captcha\CaptchaValidator;
use Yii;
use yii\base\Model;

class ContactForm extends Model
{
    public string $name = '';
    public string $email = '';
    public string $subject = '';
    public string $body = '';
    public string $verifyCode = '';

    public function rules(): array
    {
        return [
            [['name', 'email', 'subject', 'body', 'verifyCode'], 'required'],
            ['email', 'email'],
            ['verifyCode', CaptchaValidator::class]
        ];
    }

    public function attributeLabels(): array
    {
        return [];
    }

    public function contact(string $email): bool
    {
        if ($this->validate()) {
            Yii::$app->mailer
                ->compose()
                ->setTo(Yii::$app->params['senderEmail'])
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();
            return true;
        }
        return false;
    }
}
