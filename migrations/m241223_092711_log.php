<?php declare(strict_types=1);

use app\models\LogItem;
use yii\db\Migration;

// https://www.yiiframework.com/doc/guide/2.0/en/runtime-logging
class m241223_092711_log extends Migration
{
    public function safeUp(): bool
    {
        $tableName = LogItem::tableName();
        $this->createTable($tableName, [
            'id'       => $this->primaryKey(),
            'level'    => $this->integer()->null(),
            'category' => $this->string()->null(),
            'log_time' => $this->double()->null(),
            'prefix'   => $this->text()->null(),
            'message'  => $this->text()->null(),
        ]);
        $this->createIndex('idx_level', $tableName, 'level');
        $this->createIndex('idx_category', $tableName, 'category');
        return true;
    }

    public function safeDown(): bool
    {
        $tableName = LogItem::tableName();
        $this->dropTable($tableName);
        return true;
    }
}
