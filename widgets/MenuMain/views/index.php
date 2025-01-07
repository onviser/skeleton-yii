<?php declare(strict_types=1);

$menu = $menu ?? [];
?>
<div>
    <?php foreach ($menu as $url => $text) { ?>
        <a href="<?= $url ?>"><?= $text ?></a>
    <?php } ?>
</div>