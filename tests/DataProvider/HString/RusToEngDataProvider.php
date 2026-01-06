<?php

namespace AndrewGos\Helpers\Tests\DataProvider\HString;

class RusToEngDataProvider
{
    public static function dataProvider(): array
    {
        return [
            'full_alphabet_lower' => [
                'input' => 'абвгдейёжзийклмнопрстуфхцчшщъыьэюя',
                'expected' => 'abvgdeyezhziyklmnoprstufkhtschshshchyeyuya',
            ],
            'full_alphabet_upper' => [
                'input' => 'АБВГДЕЙЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ',
                'expected' => 'ABVGDEYEZhZIYKLMNOPRSTUFKhTsChShShchYEYuYa',
            ],
            'mixed_case_and_special' => [
                'input' => 'Привет, Мир! 123',
                'expected' => 'Privet, Mir! 123',
            ],
            'hard_soft_signs' => [
                'input' => 'Подъезд, Конь',
                'expected' => 'Podezd, Kon',
            ],
            'latin_untouched' => [
                'input' => 'Hello World',
                'expected' => 'Hello World',
            ],
        ];
    }
}
