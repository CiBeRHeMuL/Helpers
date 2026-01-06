<?php

namespace AndrewGos\Helpers\Tests\DataProvider\HString;

use Random\Engine\Secure;

class RandomNumericStringDataProvider
{
    public static function dataProvider(): array
    {
        $simpleLength = rand(0, 100);
        $customEngineLength = rand(0, 100);
        return [
            'simple' => [
                'length' => $simpleLength,
                'engine' => null,
                'expectedRegex' => self::regex($simpleLength),
            ],
            'custom_engine' => [
                'length' => $customEngineLength,
                'engine' => new Secure(),
                'expectedRegex' => self::regex($customEngineLength),
            ],
        ];
    }

    public static function regex(int $length): string
    {
        return sprintf(
            '/\d{%s}/ui',
            $length,
        );
    }
}
