<?php declare(strict_types=1);

use app\models\blocker\BlockerIp;
use yii\db\Migration;

class m250106_145319_blocker extends Migration
{
    public function safeUp(): bool
    {
        $tableName = BlockerIp::tableName();
        $this->createTable($tableName, [
            'blocker_id'      => $this->primaryKey(),
            'blocker_ip'      => $this->string(60)->defaultValue(''),
            'blocker_action'  => $this->tinyInteger()->unsigned()->defaultValue(0),
            'blocker_minute'  => $this->tinyInteger()->unsigned()->defaultValue(0),
            'blocker_attempt' => $this->tinyInteger()->unsigned()->defaultValue(0),
            'blocker_add'     => $this->integer()->unsigned()->defaultValue(0),
            'blocker_update'  => $this->integer()->unsigned()->defaultValue(0),
            'blocker_off'     => $this->integer()->unsigned()->defaultValue(0),
        ]);
        $this->createIndex('idx_ip', $tableName, 'blocker_ip');
        $this->createIndex('idx_action', $tableName, 'blocker_action');
        $this->createIndex('idx_off', $tableName, 'blocker_off');
        return true;
    }

    public function safeDown(): bool
    {
        $tableName = BlockerIp::tableName();
        $this->dropTable($tableName);
        return true;
    }
}
