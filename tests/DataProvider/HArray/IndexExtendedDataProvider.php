<?php

namespace AndrewGos\Helpers\Tests\DataProvider\HArray;

use ArrayIterator;

class IndexExtendedDataProvider
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
                'projection' => null,
                'defaultIndex' => null,
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
                'projection' => null,
                'defaultIndex' => null,
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
                'projection' => null,
                'defaultIndex' => null,
                'expected' => [
                    'John Doe 1' => ['id' => 1, 'name' => 'John Doe 1'],
                    'John Doe 2' => ['id' => 2, 'name' => 'John Doe 2'],
                    'John Doe 3' => ['id' => 3, 'name' => 'John Doe 3'],
                ],
            ],
            'projection' => [
                'input' => new ArrayIterator([
                    ['id' => 1, 'name' => 'John Doe 1'],
                    ['id' => 2, 'name' => 'John Doe 2'],
                    ['id' => 3, 'name' => 'John Doe 3'],
                ]),
                'key' => self::keyFunction(...),
                'projection' => self::projectionFunction(...),
                'defaultIndex' => null,
                'expected' => [
                    'John Doe 1' => 'John Doe 1',
                    'John Doe 2' => 'John Doe 2',
                    'John Doe 3' => 'John Doe 3',
                ],
            ],
            'default_index' => [
                'input' => new ArrayIterator([
                    ['id' => 1, 'name' => 'John Doe 1'],
                    ['id' => 2, 'name' => 'John Doe 2'],
                    ['name' => 'John Doe 3'],
                ]),
                'key' => 'id',
                'projection' => self::projectionFunction(...),
                'defaultIndex' => 3,
                'expected' => [
                    1 => 'John Doe 1',
                    2 => 'John Doe 2',
                    3 => 'John Doe 3',
                ],
            ],
            'default_index_function' => [
                'input' => new ArrayIterator([
                    ['id' => 1, 'name' => 'John Doe 1'],
                    ['id' => 2, 'name' => 'John Doe 2'],
                    ['name' => 'John Doe 3'],
                ]),
                'key' => 'id',
                'projection' => self::projectionFunction(...),
                'defaultIndex' => self::defaultIndexFunction(...),
                'expected' => [
                    1 => 'John Doe 1',
                    2 => 'John Doe 2',
                    'John Doe 3' => 'John Doe 3',
                ],
            ],
        ];
    }

    public static function keyFunction(array $e): string
    {
        return $e['name'];
    }

    public static function projectionFunction(array $e): string
    {
        return $e['name'];
    }

    public static function defaultIndexFunction(array $el): string
    {
        return $el['name'];
    }
}
