<?php declare(strict_types=1);

namespace app\models\blocker;

use yii\db\ActiveRecord;
use yii\db\Exception;

class BlockerIp extends ActiveRecord
{
    const ACTION_LOGIN = 1;
    const ACTION_FEEDBACK = 2;

    const ATTEMPT_LOGIN = 3;
    const ATTEMPT_FEEDBACK = 3;

    const MINUTE_LOGIN = 5;
    const MINUTE_FEEDBACK = 5;

    public static function tableName(): string
    {
        return '{{%blocker_ip}}';
    }

    public function getAttempt(): int
    {
        return intval($this->blocker_attempt);
    }

    /**
     * Checking the number of attempts.
     * @param string $ip
     * @param int $action
     * @param int $minute
     * @param int $attempt
     * @return bool
     * @throws Exception
     */
    public static function check(string $ip, int $action, int $minute, int $attempt): bool
    {
        /**
         * @var BlockerIp $blockerInDatabase
         * @var BlockerIp $blocker
         */

        self::cleaning();

        $blockerInDatabase = BlockerIp::find()
            ->andWhere(['=', 'blocker_ip', $ip])
            ->andWhere(['=', 'blocker_action', $action])
            ->andWhere(['>', 'blocker_off', time()])
            ->orderBy('blocker_id DESC')
            ->one();
        if (isset($blockerInDatabase)) {
            if ($blockerInDatabase->getAttempt() >= $attempt) {
                return false;
            }
            $blockerInDatabase->blocker_attempt = $blockerInDatabase->getAttempt() + 1;
            $blockerInDatabase->blocker_update = time();
            $blockerInDatabase->save();
            return true;
        }

        // блокировки еще нет в базе
        $blocker = new BlockerIp();
        $blocker->blocker_ip = $ip;
        $blocker->blocker_action = $action;
        $blocker->blocker_minute = $minute;
        $blocker->blocker_attempt = 1;
        $blocker->blocker_add = time();
        $blocker->blocker_update = $blocker->blocker_add;
        $blocker->blocker_off = $blocker->blocker_add + $blocker->blocker_minute * 60;
        $blocker->save();

        return true;
    }

    /**
     * Delete old IP blocking records.
     * @return bool
     * @throws Exception
     */
    public static function cleaning(): bool
    {
        $tableName = self::tableName();
        $timeOff = time();
        $sql = "DELETE FROM {$tableName} WHERE blocker_off < {$timeOff}";
        static::getDb()->createCommand($sql)->execute();
        return true;
    }

    /**
     * Get user's IP address based on HTTP headers.
     * @param array $headers
     * @return string
     */
    public static function getIpFromHeaders(array $headers): string
    {
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $headers) && ($headers['HTTP_X_FORWARDED_FOR'] !== '')) {
            $ip = $headers['HTTP_X_FORWARDED_FOR'];
        } elseif (array_key_exists('CLIENT_IP', $headers) && ($headers['CLIENT_IP'] !== '')) {
            $ip = $headers['CLIENT_IP'];
        } elseif (array_key_exists('REMOTE_ADDR', $headers) && ($headers['REMOTE_ADDR'] !== '')) {
            $ip = $headers['REMOTE_ADDR'];
        } else {
            return '';
        }

        // IPv4
        if (preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $ip)) {
            return $ip;
        }

        // IPv6
        return $ip;
    }
}