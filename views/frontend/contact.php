<?php declare(strict_types=1);

/**
 * @var yii\web\View $this
 * @var app\models\ContactForm $model
 */

use app\common\Captcha\CaptchaGenerator;
use app\widgets\Captcha\CaptchaWidget;
use app\widgets\MenuMain\MenuMainWidget;
use yii\helpers\Html;

$this->title = 'Contact';
?>
<?= MenuMainWidget::widget() ?>
<h1><?= Html::encode($this->title) ?></h1>
<?php if (Yii::$app->session->hasFlash('contactFormSubmitted')) { ?>
    <div>
        Thank you for contacting us. We will respond to you as soon as possible.
    </div>
<?php } else { ?>
    <form method="post" action="">
        <?= Html::activeLabel($model, 'name') ?>
        <?= Html::activeTextInput($model, 'name', ['autofocus' => true]) ?>
        <?= Html::error($model, 'name') ?>
        <hr/>
        <?= Html::activeLabel($model, 'email') ?>
        <?= Html::activeTextInput($model, 'email') ?>
        <?= Html::error($model, 'email') ?>
        <hr/>
        <?= Html::activeLabel($model, 'subject') ?>
        <?= Html::activeTextInput($model, 'subject') ?>
        <?= Html::error($model, 'subject') ?>
        <hr/>
        <?= Html::activeLabel($model, 'body') ?>
        <?= Html::activeTextarea($model, 'body', ['rows' => 6]) ?>
        <?= Html::error($model, 'body') ?>
        <hr/>
        <?= Html::activeLabel($model, 'verifyCode') ?>
        <?= Html::activeTextInput($model, 'verifyCode') ?>
        <?= CaptchaWidget::widget([
            'width'              => 150,
            'height'             => 50,
            'character'          => CaptchaGenerator::CHARACTER_ALL,
            'numberOfCharacters' => 5,
        ]) ?>
        <?= Html::error($model, 'verifyCode') ?>
        <hr/>
        <?= Html::submitButton('Submit') ?>
        <?= Html::hiddenInput(Yii::$app->getRequest()->csrfParam, Yii::$app->getRequest()->getCsrfToken()); ?>
    </form>
<?php } ?>
