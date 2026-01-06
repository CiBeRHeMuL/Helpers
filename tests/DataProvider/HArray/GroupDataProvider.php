<?php

namespace AndrewGos\Helpers\Tests\DataProvider\HArray;

use ArrayIterator;

class GroupDataProvider
{
    public static function dataProvider(): array
    {
        return [
            'string_key' => [
                'input' => [
                    ['id' => 1, 'city' => 'Moscow', 'name' => 'John Doe 1'],
                    ['id' => 2, 'city' => 'Moscow', 'name' => 'John Doe 2'],
                    ['id' => 3, 'city' => 'Samara', 'name' => 'John Doe 3'],
                    ['id' => 4, 'city' => 'Male', 'name' => 'John Doe 4'],
                ],
                'key' => 'city',
                'preserveKeys' => false,
                'expected' => [
                    'Moscow' => [
                        ['id' => 1, 'city' => 'Moscow', 'name' => 'John Doe 1'],
                        ['id' => 2, 'city' => 'Moscow', 'name' => 'John Doe 2'],
                    ],
                    'Samara' => [
                        ['id' => 3, 'city' => 'Samara', 'name' => 'John Doe 3'],
                    ],
                    'Male' => [
                        ['id' => 4, 'city' => 'Male', 'name' => 'John Doe 4'],
                    ],
                ],
            ],
            'function_key' => [
                'input' => [
                    ['id' => 1, 'city' => 'Moscow', 'name' => 'John Doe 1'],
                    ['id' => 2, 'city' => 'Moscow', 'name' => 'John Doe 2'],
                    ['id' => 3, 'city' => 'Samara', 'name' => 'John Doe 3'],
                    ['id' => 4, 'city' => 'Male', 'name' => 'John Doe 4'],
                ],
                'key' => self::keyFunction(...),
                'preserveKeys' => false,
                'expected' => [
                    'Moscow' => [
                        ['id' => 1, 'city' => 'Moscow', 'name' => 'John Doe 1'],
                        ['id' => 2, 'city' => 'Moscow', 'name' => 'John Doe 2'],
                    ],
                    'Samara' => [
                        ['id' => 3, 'city' => 'Samara', 'name' => 'John Doe 3'],
                    ],
                    'Male' => [
                        ['id' => 4, 'city' => 'Male', 'name' => 'John Doe 4'],
                    ],
                ],
            ],
            'iterator' => [
                'input' => new ArrayIterator([
                    ['id' => 1, 'city' => 'Moscow', 'name' => 'John Doe 1'],
                    ['id' => 2, 'city' => 'Moscow', 'name' => 'John Doe 2'],
                    ['id' => 3, 'city' => 'Samara', 'name' => 'John Doe 3'],
                    ['id' => 4, 'city' => 'Male', 'name' => 'John Doe 4'],
                ]),
                'key' => 'city',
                'preserveKeys' => false,
                'expected' => [
                    'Moscow' => [
                        ['id' => 1, 'city' => 'Moscow', 'name' => 'John Doe 1'],
                        ['id' => 2, 'city' => 'Moscow', 'name' => 'John Doe 2'],
                    ],
                    'Samara' => [
                        ['id' => 3, 'city' => 'Samara', 'name' => 'John Doe 3'],
                    ],
                    'Male' => [
                        ['id' => 4, 'city' => 'Male', 'name' => 'John Doe 4'],
                    ],
                ],
            ],
            'preserve_keys' => [
                'input' => [
                    1 => ['id' => 1, 'city' => 'Moscow', 'name' => 'John Doe 1'],
                    2 => ['id' => 2, 'city' => 'Moscow', 'name' => 'John Doe 2'],
                    3 => ['id' => 3, 'city' => 'Samara', 'name' => 'John Doe 3'],
                    4 => ['id' => 4, 'city' => 'Male', 'name' => 'John Doe 4'],
                ],
                'key' => 'city',
                'preserveKeys' => true,
                'expected' => [
                    'Moscow' => [
                        1 => ['id' => 1, 'city' => 'Moscow', 'name' => 'John Doe 1'],
                        2 => ['id' => 2, 'city' => 'Moscow', 'name' => 'John Doe 2'],
                    ],
                    'Samara' => [
                        3 => ['id' => 3, 'city' => 'Samara', 'name' => 'John Doe 3'],
                    ],
                    'Male' => [
                        4 => ['id' => 4, 'city' => 'Male', 'name' => 'John Doe 4'],
                    ],
                ],
            ],
            'nested_groups' => [
                'input' => [
                    1 => [
                        'id' => 1,
                        'city' => 'Moscow',
                        'street' => 'Tverskaya',
                        'name' => 'John Doe 1',
                    ],
                    2 => [
                        'id' => 2,
                        'city' => 'Moscow',
                        'street' => 'Mira',
                        'name' => 'John Doe 2',
                    ],
                    3 => [
                        'id' => 3,
                        'city' => 'Samara',
                        'street' => 'Mira',
                        'name' => 'John Doe 3',
                    ],
                    4 => [
                        'id' => 4,
                        'city' => 'Male',
                        'street' => 'Mira',
                        'name' => 'John Doe 4',
                    ],
                ],
                'key' => ['city', 'street'],
                'preserveKeys' => true,
                'expected' => [
                    'Moscow' => [
                        'Tverskaya' => [
                            1 => [
                                'id' => 1,
                                'city' => 'Moscow',
                                'street' => 'Tverskaya',
                                'name' => 'John Doe 1',
                            ],
                        ],
                        'Mira' => [
                            2 => [
                                'id' => 2,
                                'city' => 'Moscow',
                                'street' => 'Mira',
                                'name' => 'John Doe 2',
                            ],
                        ],
                    ],
                    'Samara' => [
                        'Mira' => [
                            3 => [
                                'id' => 3,
                                'city' => 'Samara',
                                'street' => 'Mira',
                                'name' => 'John Doe 3',
                            ],
                        ],
                    ],
                    'Male' => [
                        'Mira' => [
                            4 => [
                                'id' => 4,
                                'city' => 'Male',
                                'street' => 'Mira',
                                'name' => 'John Doe 4',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public static function keyFunction(array $e): string
    {
        return $e['city'];
    }
}
