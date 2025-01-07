<?php declare(strict_types=1);

namespace app\commands;

use app\models\User;
use Exception;
use Throwable;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * User management.
 */
class UserController extends Controller
{
    /**
     * Creating a new user.
     * @return int
     */
    public function actionCreate(): int
    {
        $groupId = intval(readline("group_id: "));
        $email = trim(strval(readline("email: ")));
        $password = trim(strval(readline("password: ")));

        try {
            $user = new User();
            $user->setGroupId($groupId);
            $user->setEmail($email);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
            $user->setStatus(User::STATUS_ACTIVE);

            if ($user->save() === false) {
                $errors = [];
                foreach ($user->getErrors() as $filedName => $fieldErrors) {
                    $errors[] = "Field error [$filedName]: " . implode(', ', $fieldErrors);
                }
                throw new Exception(implode(', ', $errors));
            }
            $this->stdout("User added." . PHP_EOL);
            return ExitCode::OK;
        } catch (Exception $exception) {
            $this->stderr("$exception");
        }
        return ExitCode::UNSPECIFIED_ERROR;
    }

    /**
     * Updating an existing user.
     * @return int
     */
    public function actionUpdate(): int
    {
        $userId = intval(readline("user_id: "));
        try {
            $user = User::findOne($userId);
            if ($user === null) {
                throw new Exception("User with id {$userId} was not found");
            }

            $user->setGroupId(intval(readline("group_id ({$user->getGroupId()}): ")));
            $user->setEmail(trim(strval(readline("email ({$user->getEmail()}): "))));
            $user->setPassword(password_hash(trim(strval(readline("password: "))), PASSWORD_DEFAULT));
            $user->setStatus(intval(readline("status ({$user->getStatus()}): ")));

            if ($user->save() === false) {
                $errors = [];
                foreach ($user->getErrors() as $filedName => $fieldErrors) {
                    $errors[] = "Field error [$filedName]: " . implode(', ', $fieldErrors);
                }
                throw new Exception(implode(', ', $errors));
            }
            $this->stdout("User updated." . PHP_EOL);
            return ExitCode::OK;
        } catch (Exception $exception) {
            $this->stderr("$exception");
        }
        return ExitCode::UNSPECIFIED_ERROR;
    }

    /**
     * Deleting a user.
     * @return int
     */
    public function actionDelete(): int
    {
        $userId = intval(readline("user_id: "));
        try {
            $user = User::findOne($userId);
            if ($user === null) {
                throw new Exception("User with id {$userId} was not found");
            }
            $user->delete();
            $this->stdout("User deleted." . PHP_EOL);
            return ExitCode::OK;
        } catch (Exception|Throwable $exception) {
            $this->stderr("$exception");
        }
        return ExitCode::UNSPECIFIED_ERROR;
    }

    /**
     * User list.
     * @return int
     */
    public function actionList(): int
    {
        /** @var User[] $users */
        $users = User::find()
            ->orderBy('created_at')
            ->all();
        foreach ($users as $user) {
            $this->stdout("{$user->user_id}: {$user->user_email}" . PHP_EOL);
        }
        return ExitCode::OK;
    }
}