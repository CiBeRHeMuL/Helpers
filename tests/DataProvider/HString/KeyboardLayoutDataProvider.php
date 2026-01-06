<?php

namespace AndrewGos\Helpers\Tests\DataProvider\HString;

class KeyboardLayoutDataProvider
{
    public static function dataProvider(): array
    {
        return [
            'standard_phrase' => [
                'eng' => 'ghbdtn vbh',
                'rus' => 'привет мир',
            ],
            'symbols_and_numbers' => [
                'eng' => '`1234567890-=',
                'rus' => ']1234567890-=',
            ],
            'uppercase_layout' => [
                'eng' => 'QWERTY UIOP{}',
                'rus' => 'ЙЦУКЕН ГШЩЗХЪ',
            ],
            'complex_punctuation' => [
                'eng' => '.,\';[]\\',
                'rus' => 'юбэжхъё',
            ],
            'shift_symbols' => [
                'eng' => '~!@#$%^&*()_+',
                'rus' => '[!"№%:,.;()_+',
            ],
        ];
    }
}
