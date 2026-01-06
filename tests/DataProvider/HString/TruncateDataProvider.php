<?php

namespace AndrewGos\Helpers\Tests\DataProvider\HString;

class TruncateDataProvider
{
    public static function dataProvider(): array
    {
        return [
            'short' => [
                'inputString' => 'Short',
                'maxLength' => 20,
                'ellipsis' => '...',
                'encoding' => 'UTF-8',
                'expected' => 'Short',
            ],
            'long' => [
                'inputString' => 'Loooooooooooooooooooooooooooooooooong',
                'maxLength' => 30,
                'ellipsis' => '...',
                'encoding' => 'UTF-8',
                'expected' => 'Looooooooooooooooooooooooooooo...',
            ],
        ];
    }
}
