<?php declare(strict_types=1);

namespace app\test;

use app\common\EnvVariable\EnvVariable;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class EnvVariableTest extends TestCase
{
    #[DataProvider('providerGet')]
    public function testGet(string $valueExpected, string $value): void
    {
        $this->assertEquals($valueExpected, $value);
    }

    public static function providerGet(): Generator
    {
        $someDSN = 'mysql:host=mysql;port=3306;dbname=skeleton_yii';
        $someKey = 'P2mEJ@i$fue2JIr#W8Gmk{R*qDz|~Tn8_';
        $somePassword = 'YKppaL6t4lY*7{vPK}5Rcbv~*a~CcgOhYhJkk|TBFBSe~sILLd6%7kfO?Jb{~NO$';

        $envVariable = new EnvVariable("YII_DEBUG = true
YII_ENV = dev

SOME_KEY = $someKey

DB_DSN = $someDSN
DB_USERNAME = someLogin
DB_PASSWORD = $somePassword");

        yield [
            'true',
            $envVariable->get('YII_DEBUG')
        ];
        yield [
            'dev',
            $envVariable->get('YII_ENV')
        ];
        yield [
            $someDSN,
            $envVariable->get('DB_DSN')
        ];
        yield [
            'someLogin',
            $envVariable->get('DB_USERNAME')
        ];
        yield [
            $somePassword,
            $envVariable->get('DB_PASSWORD')
        ];
        yield [
            $someKey,
            $envVariable->get('SOME_KEY')
        ];
    }
}