<?php declare(strict_types=1);

namespace app\common\Captcha;

class CaptchaGenerator
{
    public const SESSION_KEY = 'captcha';
    public const CHARACTER_NUMBER = 1 << 0;
    public const CHARACTER_LETTER = 1 << 1;
    public const CHARACTER_ALL = self::CHARACTER_NUMBER | self::CHARACTER_LETTER;
    public const NUMBER_OF_CHARACTERS = 5;

    protected int $character = self::CHARACTER_ALL;
    protected int $numberOfCharacters = self::NUMBER_OF_CHARACTERS;

    public function setCharacter(int $character): self
    {
        $this->character = $character;
        return $this;
    }

    public function setNumberOfCharacters(int $amountCharacter): self
    {
        $this->numberOfCharacters = $amountCharacter;
        return $this;
    }

    public function generate(): string
    {
        $characters = [];
        if ($this->character & self::CHARACTER_NUMBER) {
            $characters = array_merge($characters, [
                //'0', similar to O
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9'
            ]);
        }
        if ($this->character & self::CHARACTER_LETTER) {
            $characters = array_merge($characters, [
                'a',
                'b',
                'c',
                'd',
                'e',
                'f',
                'j',
                'h',
                'i',
                'g',
                'k',
                //'l', similar to 1
                'm',
                'n',
                //'o', similar to 0
                'p',
                'q',
                'r',
                's',
                't',
                'u',
                'v',
                'w',
                'x',
                'y',
                'z',
            ]);
        }
        shuffle($characters);
        return implode('', array_slice($characters, 0, $this->numberOfCharacters));
    }
}