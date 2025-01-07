<?php declare(strict_types=1);

use yii\data\Pagination;

/**
 * @var Pagination $pagination
 * @var string $pagePrev
 * @var string $pageNext
 * @var string[] $pages
 */
?>
<?php if ($pagination->getPageCount() > 1) { ?>
    <div>
        <nav>
            <?php if ($pagePrev !== '') { ?>
                <a href="<?= $pagePrev ?>"></a>
            <?php } ?>
            <?php foreach ($pages as $page => $url) { ?>
                <?php if (in_array($page, ['...', '..<', '..>'])) { ?>
                    <span>...</span>
                <?php } else { ?>
                    <a href="<?= $url ?>"><?= $page ?></a>
                <?php } ?>
            <?php } ?>
            <?php if ($pageNext !== '') { ?>
                <a href="<?= $pageNext ?>">Вперед</a>
            <?php } ?>
        </nav>
    </div>
<?php } ?>