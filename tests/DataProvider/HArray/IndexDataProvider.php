<?php

namespace AndrewGos\Helpers\Tests\DataProvider\HArray;

use ArrayIterator;

class IndexDataProvider
{
    public static function dataProvider(): array
    {
        return [
            'string_key' => [
                'input' => [
                    ['id' => 1, 'name' => 'John Doe 1'],
                    ['id' => 2, 'name' => 'John Doe 2'],
                    ['id' => 3, 'name' => 'John Doe 3'],
                ],
                'key' => 'name',
                'expected' => [
                    'John Doe 1' => ['id' => 1, 'name' => 'John Doe 1'],
                    'John Doe 2' => ['id' => 2, 'name' => 'John Doe 2'],
                    'John Doe 3' => ['id' => 3, 'name' => 'John Doe 3'],
                ],
            ],
            'iterator' => [
                'input' => new ArrayIterator([
                    ['id' => 1, 'name' => 'John Doe 1'],
                    ['id' => 2, 'name' => 'John Doe 2'],
                    ['id' => 3, 'name' => 'John Doe 3'],
                ]),
                'key' => 'id',
                'expected' => [
                    1 => ['id' => 1, 'name' => 'John Doe 1'],
                    2 => ['id' => 2, 'name' => 'John Doe 2'],
                    3 => ['id' => 3, 'name' => 'John Doe 3'],
                ],
            ],
            'function_key' => [
                'input' => new ArrayIterator([
                    ['id' => 1, 'name' => 'John Doe 1'],
                    ['id' => 2, 'name' => 'John Doe 2'],
                    ['id' => 3, 'name' => 'John Doe 3'],
                ]),
                'key' => self::keyFunction(...),
                'expected' => [
                    'John Doe 1' => ['id' => 1, 'name' => 'John Doe 1'],
                    'John Doe 2' => ['id' => 2, 'name' => 'John Doe 2'],
                    'John Doe 3' => ['id' => 3, 'name' => 'John Doe 3'],
                ],
            ],
        ];
    }

    public static function keyFunction(array $e): string
    {
        return $e['name'];
    }
}
