<?php declare(strict_types=1);

use app\models\User;
use app\widgets\MenuMain\MenuMainWidget;

/**
 * @var User $user
 */

$this->title = 'Admin / Dashboard';
?>
<?= MenuMainWidget::widget() ?>
<h1><?= $this->title ?></h1>
<p>
    id: <?= $user->getId() ?><br/>
    groupId: <?= $user->getGroupId() ?><br/>
    email: <?= $user->getEmail() ?><br/>
    status: <?= $user->getStatus() ?><br/>
</p>