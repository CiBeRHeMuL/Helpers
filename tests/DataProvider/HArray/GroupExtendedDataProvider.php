<?php

namespace AndrewGos\Helpers\Tests\DataProvider\HArray;

use ArrayIterator;

class GroupExtendedDataProvider
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
                'index' => 'id',
                'projection' => null,
                'preserveKeys' => false,
                'defaultIndex' => null,
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
            'function_key' => [
                'input' => [
                    ['id' => 1, 'city' => 'Moscow', 'name' => 'John Doe 1'],
                    ['id' => 2, 'city' => 'Moscow', 'name' => 'John Doe 2'],
                    ['id' => 3, 'city' => 'Samara', 'name' => 'John Doe 3'],
                    ['id' => 4, 'city' => 'Male', 'name' => 'John Doe 4'],
                ],
                'key' => self::keyFunction(...),
                'index' => 'id',
                'projection' => null,
                'preserveKeys' => false,
                'defaultIndex' => null,
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
            'iterator' => [
                'input' => new ArrayIterator([
                    ['id' => 1, 'city' => 'Moscow', 'name' => 'John Doe 1'],
                    ['id' => 2, 'city' => 'Moscow', 'name' => 'John Doe 2'],
                    ['id' => 3, 'city' => 'Samara', 'name' => 'John Doe 3'],
                    ['id' => 4, 'city' => 'Male', 'name' => 'John Doe 4'],
                ]),
                'key' => 'city',
                'index' => 'id',
                'projection' => null,
                'preserveKeys' => false,
                'defaultIndex' => null,
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
            'function_index' => [
                'input' => [
                    1 => ['id' => 1, 'city' => 'Moscow', 'name' => 'John Doe 1'],
                    2 => ['id' => 2, 'city' => 'Moscow', 'name' => 'John Doe 2'],
                    3 => ['id' => 3, 'city' => 'Samara', 'name' => 'John Doe 3'],
                    4 => ['id' => 4, 'city' => 'Male', 'name' => 'John Doe 4'],
                ],
                'key' => 'city',
                'index' => self::indexFunction(...),
                'projection' => null,
                'preserveKeys' => false,
                'defaultIndex' => null,
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
                'index' => 'id',
                'projection' => null,
                'preserveKeys' => false,
                'defaultIndex' => null,
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
            'duplicate_index' => [
                'input' => [
                    [
                        'id' => 1,
                        'city' => 'Moscow',
                        'street' => 'Tverskaya',
                        'name' => 'John Doe 1',
                    ],
                    [
                        'id' => 2,
                        'city' => 'Moscow',
                        'street' => 'Mira',
                        'name' => 'John Doe 2',
                    ],
                    [
                        'id' => 3,
                        'city' => 'Samara',
                        'street' => 'Mira',
                        'name' => 'John Doe 3',
                    ],
                    [
                        'id' => 4,
                        'city' => 'Male',
                        'street' => 'Mira',
                        'name' => 'John Doe 4',
                    ],
                    [
                        'id' => 4,
                        'city' => 'Male',
                        'street' => 'Mira',
                        'name' => 'John Doe 5',
                    ],
                ],
                'key' => ['city', 'street'],
                'index' => 'id',
                'projection' => null,
                'preserveKeys' => false,
                'defaultIndex' => null,
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
                                'name' => 'John Doe 5',
                            ],
                        ],
                    ],
                ],
            ],
            'default_index' => [
                'input' => [
                    ['id' => 1, 'city' => 'Moscow', 'name' => 'John Doe 1'],
                    ['id' => 2, 'city' => 'Moscow', 'name' => 'John Doe 2'],
                    ['id' => 3, 'city' => 'Samara', 'name' => 'John Doe 3'],
                    ['id' => 4, 'city' => 'Male', 'name' => 'John Doe 4'],
                    ['city' => 'Male', 'name' => 'John Doe 4'],
                ],
                'key' => 'city',
                'index' => 'id',
                'projection' => null,
                'preserveKeys' => false,
                'defaultIndex' => 5,
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
                        5 => ['city' => 'Male', 'name' => 'John Doe 4'],
                    ],
                ],
            ],
            'default_index_function' => [
                'input' => [
                    ['id' => 1, 'city' => 'Moscow', 'name' => 'John Doe 1'],
                    ['id' => 2, 'city' => 'Moscow', 'name' => 'John Doe 2'],
                    ['id' => 3, 'city' => 'Samara', 'name' => 'John Doe 3'],
                    ['id' => 4, 'city' => 'Male', 'name' => 'John Doe 4'],
                    ['city' => 'Male', 'name' => 'John Doe 4'],
                ],
                'key' => 'city',
                'index' => 'id',
                'projection' => null,
                'preserveKeys' => false,
                'defaultIndex' => self::defaultIndexFunction(...),
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
                        'Male John Doe 4' => ['city' => 'Male', 'name' => 'John Doe 4'],
                    ],
                ],
            ],
            'projection' => [
                'input' => [
                    ['id' => 1, 'city' => 'Moscow', 'name' => 'John Doe 1'],
                    ['id' => 2, 'city' => 'Moscow', 'name' => 'John Doe 2'],
                    ['id' => 3, 'city' => 'Samara', 'name' => 'John Doe 3'],
                    ['id' => 4, 'city' => 'Male', 'name' => 'John Doe 4'],
                    ['city' => 'Male', 'name' => 'John Doe 5'],
                ],
                'key' => 'city',
                'index' => 'id',
                'projection' => self::projectionFunction(...),
                'preserveKeys' => false,
                'defaultIndex' => 5,
                'expected' => [
                    'Moscow' => [
                        1 => 'John Doe 1',
                        2 => 'John Doe 2',
                    ],
                    'Samara' => [
                        3 => 'John Doe 3',
                    ],
                    'Male' => [
                        4 => 'John Doe 4',
                        5 => 'John Doe 5',
                    ],
                ],
            ],
            'preserve_keys' => [
                'input' => [
                    1 => ['id' => 1, 'city' => 'Moscow', 'name' => 'John Doe 1'],
                    2 => ['id' => 2, 'city' => 'Moscow', 'name' => 'John Doe 2'],
                    3 => ['id' => 3, 'city' => 'Samara', 'name' => 'John Doe 3'],
                    4 => ['id' => 4, 'city' => 'Male', 'name' => 'John Doe 4'],
                    5 => ['city' => 'Male', 'name' => 'John Doe 5'],
                ],
                'key' => 'city',
                'index' => 'id',
                'projection' => self::projectionFunction(...),
                'preserveKeys' => true,
                'defaultIndex' => null,
                'expected' => [
                    'Moscow' => [
                        1 => 'John Doe 1',
                        2 => 'John Doe 2',
                    ],
                    'Samara' => [
                        3 => 'John Doe 3',
                    ],
                    'Male' => [
                        4 => 'John Doe 4',
                        5 => 'John Doe 5',
                    ],
                ],
            ],
        ];
    }

    public static function keyFunction(array $e): string
    {
        return $e['city'];
    }

    public static function indexFunction(array $e): string
    {
        return $e['id'];
    }

    public static function projectionFunction(array $e): string
    {
        return $e['name'];
    }

    public static function defaultIndexFunction(array $e): string
    {
        return $e['city'] . ' ' . $e['name'];
    }
}
