<?php

namespace AndrewGos\Helpers\Tests\DataProvider\HString;

use Random\Engine\Secure;

class RandomStringDataProvider
{
    public static function dataProvider(): array
    {
        $simpleLength = rand(1, 100);
        $withDigitsLength = rand(1, 100);
        $customEngineLength = rand(1, 100);
        return [
            'simple' => [
                'length' => $simpleLength,
                'includeDigits' => false,
                'engine' => null,
                'expectedRegex' => self::regex(false, $simpleLength),
            ],
            'with_digits' => [
                'length' => $withDigitsLength,
                'includeDigits' => true,
                'engine' => null,
                'expectedRegex' => self::regex(true, $withDigitsLength),
            ],
            'custom_engine' => [
                'length' => $customEngineLength,
                'includeDigits' => true,
                'engine' => new Secure(),
                'expectedRegex' => self::regex(true, $customEngineLength),
            ],
        ];
    }

    public static function regex(bool $includeDigits, int $length): string
    {
        return sprintf(
            '/[a-zA-Z%s]{%s}/ui',
            $includeDigits ? '\d' : '',
            $length,
        );
    }
}
