<?php declare(strict_types=1);

namespace app\models;

use yii\db\ActiveRecord;

class SessionItem extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'session';
    }
}