<?php declare(strict_types=1);

/**
 * @var yii\web\View $this
 * @var string $name
 * @var string $message
 * @var Exception $exception
 */

use app\widgets\MenuMain\MenuMainWidget;
use yii\helpers\Html;

$this->title = 'Error';
?>
<?= MenuMainWidget::widget() ?>
<h1><?= Html::encode($this->title) ?></h1>
<div>
    <?= nl2br(Html::encode($message)) ?>
</div>