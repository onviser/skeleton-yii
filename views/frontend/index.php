<?php declare(strict_types=1);

use app\widgets\MenuMain\MenuMainWidget;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 */

$this->title = 'Main';
?>
<?= MenuMainWidget::widget() ?>
<h1><?= Html::encode($this->title) ?></h1>
