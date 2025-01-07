<?php declare(strict_types=1);

use app\models\SessionItem;
use yii\db\Migration;

// https://www.yiiframework.com/doc/api/2.0/yii-web-dbsession
class m241201_135001_session extends Migration
{
    public function safeUp(): bool
    {
        $tableName = SessionItem::tableName();
        $this->createTable($tableName, [
            'id'     => 'CHAR(40) NOT NULL PRIMARY KEY',
            'expire' => 'INTEGER UNSIGNED DEFAULT NULL',
            'data'   => 'LONGBLOB'
        ]);
        $this->createIndex('idx_expire', $tableName, 'expire');
        return true;
    }

    public function safeDown(): bool
    {
        $tableName = SessionItem::tableName();
        $this->dropTable($tableName);
        return true;
    }
}
