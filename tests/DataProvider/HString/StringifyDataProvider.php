<?php

namespace AndrewGos\Helpers\Tests\DataProvider\HString;

use stdClass;

class StringifyDataProvider
{
    public static function dataProvider(): array
    {
        return [
            'null' => [
                'value' => null,
                'expected' => 'null',
            ],
            'bool_true' => [
                'value' => true,
                'expected' => 'true',
            ],
            'bool_false' => [
                'value' => false,
                'expected' => 'false',
            ],
            'int' => [
                'value' => 42,
                'expected' => '42',
            ],
            'float' => [
                'value' => 3.14,
                'expected' => '3.14',
            ],
            'string_simple' => [
                'value' => 'hello',
                'expected' => '"hello"',
            ],
            'string_with_quotes' => [
                'value' => 'He said "Hello"',
                'expected' => '"He said \"Hello\""',
            ],
            'array_simple' => [
                'value' => [1, 'two'],
                'expected' => '[0 => 1, 1 => "two"]',
            ],
            'array_nested' => [
                'value' => ['a' => [1], 'b' => null],
                'expected' => '[a => [0 => 1], b => null]',
            ],
            'object_stdClass' => [
                'value' => new stdClass(),
                'expected' => 'object(stdClass)',
            ],
            'object_custom' => [
                'value' => new class {},
                'expected' => '/object\(class@anonymous.*\)/',
                'isRegex' => true,
            ],
        ];
    }
}
