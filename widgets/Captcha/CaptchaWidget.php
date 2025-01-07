<?php declare(strict_types=1);

namespace app\widgets\Captcha;

use app\common\Captcha\CaptchaGenerator;
use Exception;
use GdImage;
use Yii;
use yii\base\Widget;

class CaptchaWidget extends Widget
{
    public const DEFAULT_WIDTH = 150;
    public const DEFAULT_HEIGHT = 50;

    public string $view = 'index';
    public int $width = self::DEFAULT_WIDTH;
    public int $height = self::DEFAULT_HEIGHT;
    public int $character = CaptchaGenerator::CHARACTER_ALL;
    public int $numberOfCharacters = CaptchaGenerator::NUMBER_OF_CHARACTERS;
    public string $fontFilePath = '';

    public array $colorNumber = [0x3f, 0x44, 0x46];
    public array $colorEven = [0xdb, 0xbc, 0x4a];
    public array $colorOdd = [0x79, 0x89, 0x92];

    public function run(): string
    {
        try {

            $image = imagecreate($this->width, $this->height);
            if ($image === false) {
                throw new Exception();
            }

            imagefilledrectangle($image, 0, 0, $this->width, $this->height, imagecolorallocate($image, 255, 255, 255));

            if ($this->fontFilePath === '') {
                $this->fontFilePath = Yii::getAlias('@app/web/static/font/arial.ttf');
            }
            if (file_exists($this->fontFilePath) === false) {
                throw new Exception();
            }

            $session = Yii::$app->getSession();
            $session->open();
            $text = (new CaptchaGenerator())
                ->setCharacter($this->character)
                ->setNumberOfCharacters($this->numberOfCharacters)
                ->generate();
            $session->set(CaptchaGenerator::SESSION_KEY, $text);

            $codes = str_split($text);
            foreach ($codes as $key => $character) {
                $color = $this->getColor($image, $character, $key);
                $step = $key * 28;
                $size = 28 + rand(1, 9);
                $angle = rand(-5, 5);
                $x = 5 + rand(1, 5) + $step;
                $y = 35 + rand(1, 3);
                imagettftext($image, $size, $angle, $x, $y, $color, $this->fontFilePath, $character);
            }
            ob_start();
            imagepng($image);
            $data = base64_encode(ob_get_contents());
            ob_end_clean();
        } catch (Exception $e) {
            Yii::error("{$e->getMessage()}, {$e->getTraceAsString()}");
            $data = 'iVBORw0KGgoAAAANSUhEUgAAAJYAAAAyAQMAAACEQrBZAAAAA1BMVEWokDleVTMQAAAAEElEQVQoz2MYBaNgFAx7AAAD6AABCyVq5AAAAABJRU5ErkJggg==';
        }
        return $this->render($this->view, [
            'data' => $data
        ]);
    }

    protected function getColor(GdImage $image, string $character, int $index): int
    {
        [$red, $green, $blue] = preg_match('/\d/', $character)
            ? $this->colorNumber
            : ($index % 2 === 0 ? $this->colorEven : $this->colorOdd);
        return imagecolorallocate($image, $red, $green, $blue);
    }
}