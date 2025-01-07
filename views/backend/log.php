<?php declare(strict_types=1);

use app\models\LogItem;
use app\widgets\MenuMain\MenuMainWidget;
use app\widgets\Pagination\PaginationWidget;
use yii\data\Pagination;

/**
 * @var Pagination $pagination
 * @var LogItem[] $items
 */

$this->title = 'Admin / Log';
?>
<?= MenuMainWidget::widget() ?>
<h1><?= $this->title ?></h1>
<?php if (count($items) > 0) { ?>
    <table>
        <tbody>
        <?php foreach ($items as $item) { ?>
            <tr>
                <td><?= date('Y-m-d H:i:s', intval($item->getTime())) ?></td>
                <td><?= $item->getPrefix() ?></td>
                <td><?= nl2br($item->getMessage()) ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>

<?= PaginationWidget::widget([
    'pagination' => $pagination,
    'url'        => '/' . Yii::$app->request->getPathInfo(),
    'params'     => Yii::$app->request->getQueryParams()
]) ?>

