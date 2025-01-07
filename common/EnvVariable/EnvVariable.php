<?php declare(strict_types=1);

namespace app\common\EnvVariable;

class EnvVariable
{
    protected const PATTERN = '/^([A-Z_]{1,30}) {0,}= {0,}(.{0,})$/';

    /** @var string[] */
    protected array $variables = [];

    public function __construct(string $dataFromFile)
    {
        $lines = explode(PHP_EOL, $dataFromFile);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }
            if (preg_match(self::PATTERN, $line, $match)) {
                [$name, $value] = [$match[1], $match[2]];
                putenv("$name=$value");
                $this->variables[$name] = $value;
            }
        }
    }

    public function get(string $name, string $default = ''): string
    {
        if (array_key_exists($name, $this->variables)) {
            return $this->variables[$name];
        }
        return $default;
    }
}