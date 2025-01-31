<?php declare(strict_types=1);

namespace app\models;

use yii\db\ActiveRecord;

class LogItem extends ActiveRecord
{
    public function getTime(): float
    {
        return floatval($this->log_time);
    }

    public function getPrefix(): string
    {
        return trim(strval($this->prefix));
    }

    public function getMessage(): string
    {
        return trim(strval($this->message));
    }

    public static function tableName(): string
    {
        return '{{%log}}';
    }

    public function search(
        array $params = [],
        int $page = 1,
        int $limit = 30
    ): array
    {
        $query = $this->find()
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->orderBy('log_time DESC');

        if (array_key_exists('message', $params)) {
            $query->andWhere(['LIKE', 'message', $params['message']]);
        }

        return [intval($query->count()), $query->all()];
    }
}