<?php declare(strict_types=1);

/**
 * @var yii\web\View $this
 * @var app\models\LoginForm $model
 */

use app\widgets\MenuMain\MenuMainWidget;
use yii\helpers\Html;

$this->title = 'Login';
?>
<?= MenuMainWidget::widget() ?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>
    <form method="post" action="">
        <?= Html::activeLabel($model, 'username') ?>
        <?= Html::activeTextInput($model, 'username', ['autofocus' => true]) ?>
        <?= Html::error($model, 'username') ?>
        <hr/>
        <?= Html::activeLabel($model, 'password') ?>
        <?= Html::activeTextInput($model, 'password', []) ?>
        <?= Html::error($model, 'password') ?>
        <hr/>
        <?= Html::submitButton('Login') ?>
        <?= Html::hiddenInput(Yii::$app->getRequest()->csrfParam, Yii::$app->getRequest()->getCsrfToken()); ?>
    </form>
</div>
