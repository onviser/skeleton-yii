<?php declare(strict_types=1);

use app\models\User;
use yii\db\Migration;

class m241127_161615_init extends Migration
{
    public function safeUp(): bool
    {
        $tableName = User::tableName();
        $this->createTable($tableName, [
            'user_id'       => $this->primaryKey(),
            'group_id'      => $this->tinyInteger()->unsigned()->defaultValue(User::GROUP_ID_USER),
            'user_email'    => $this->string()->notNull()->unique(),
            'user_password' => $this->string()->notNull(),
            'user_status'   => $this->tinyInteger()->unsigned()->defaultValue(User::STATUS_ACTIVE),
            'auth_key'      => $this->string()->notNull(),
            'created_at'    => $this->integer()->unsigned()->defaultValue(0),
            'updated_at'    => $this->integer()->unsigned()->defaultValue(0),
        ]);
        $this->createIndex('idx_user_group_id', $tableName, 'group_id');
        $this->createIndex('idx_user_status', $tableName, 'user_status');
        return true;
    }

    public function safeDown(): bool
    {
        $tableName = User::tableName();
        $this->dropTable($tableName);
        return true;
    }
}
