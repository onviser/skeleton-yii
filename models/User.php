<?php declare(strict_types=1);

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public const GROUP_ID_ADMIN = 1;
    public const GROUP_ID_USER = 2;

    public const STATUS_OFF = 0;
    public const STATUS_ACTIVE = 1;

    public function rules(): array
    {
        return [
            [['group_id', 'user_status', 'created_at', 'updated_at'], 'integer'],
            [['user_email', 'user_password', 'auth_key'], 'string'],
            [['group_id', 'user_email', 'user_password'], 'required']
        ];
    }

    /**
     * @throws Exception
     */
    public function beforeSave($insert): bool
    {
        $this->updated_at = time();
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString();
                $this->created_at = time();
            }
            return true;
        }
        return false;
    }

    public static function tableName(): string
    {
        return 'user';
    }

    public static function findIdentity($id): User|IdentityInterface|null
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null): User|IdentityInterface|null
    {
        return null;
    }

    public static function findActiveByEmail($username): ?User
    {
        return static::findOne([
            'user_email'  => $username,
            'user_status' => User::STATUS_ACTIVE
        ]);
    }

    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->user_password);
    }

    public function getId(): int
    {
        return $this->user_id;
    }

    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    public function setGroupId(int $groupId): self
    {
        $this->group_id = $groupId;
        return $this;
    }

    public function getGroupId(): int
    {
        return $this->group_id;
    }

    public function setEmail(string $email): self
    {
        $this->user_email = $email;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->user_email;
    }

    public function setPassword(string $password): self
    {
        $this->user_password = $password;
        return $this;
    }

    public function setStatus(int $status): self
    {
        $this->user_status = $status;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->user_status;
    }
}
