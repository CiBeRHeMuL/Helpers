<?php

namespace AndrewGos\Helpers\Tests\DataProvider\HString;

class AsBytesDataProvider
{
    public static function dataProvider(): array
    {
        return [
            'useIntl_en' => [
                'input' => (1 << 50) + (1 << 48) + (1 << 46) + (1 << 44) + (1 << 42),
                'locale' => 'en_EN',
                'useIntl' => true,
                'expected' => '1.33PB',
            ],
            'useIntl_ru' => [
                'input' => (1 << 50) + (1 << 48) + 1,
                'locale' => 'ru_RU',
                'useIntl' => true,
                'expected' => '1,25 ПБ',
            ],
            'no_useIntl_en' => [
                'input' => (1 << 50) + (1 << 48) + (1 << 46) + (1 << 44) + (1 << 42),
                'locale' => 'en_EN',
                'useIntl' => false,
                'expected' => '1.33 PB',
            ],
            'no_useIntl_ru' => [
                'input' => (1 << 50) + (1 << 48) + 1,
                'locale' => 'ru_RU',
                'useIntl' => false,
                'expected' => '1.25 PB',
            ],
        ];
    }
}
