<?php

namespace AndrewGos\Helpers\Tests\DataProvider\HArray;

use AndrewGos\Helpers\Enum\FilterModeEnum;

class FilterRecursiveDataProvider
{
    public static function dataProvider(): array
    {
        return [
            'no_callable' => [
                'input' => [
                    1,
                    [
                        1,
                        [
                            1,
                            null,
                        ],
                    ],
                    null,
                ],
                'callable' => null,
                'mode' => FilterModeEnum::UseValue,
                'preserveKeys' => false,
                'expected' => [
                    1,
                    [
                        1,
                        [
                            1,
                        ],
                    ],
                ],
            ],
            'preserve_keys' => [
                'input' => [
                    1,
                    null,
                    [
                        1,
                        [
                            null,
                            1,
                        ],
                    ],
                ],
                'callable' => null,
                'mode' => FilterModeEnum::UseValue,
                'preserveKeys' => true,
                'expected' => [
                    0 => 1,
                    2 => [
                        0 => 1,
                        1 => [
                            1 => 1,
                        ],
                    ],
                ],
            ],
            'callable_value' => [
                'input' => [
                    1,
                    [
                        1,
                        [
                            1,
                            null,
                        ],
                    ],
                    null,
                ],
                'callable' => self::callableValueFunction(...),
                'mode' => FilterModeEnum::UseValue,
                'preserveKeys' => false,
                'expected' => [
                    [
                        [
                            null,
                        ],
                    ],
                    null,
                ],
            ],
            'callable_key' => [
                'input' => [
                    1,
                    2,
                    [
                        1,
                        [
                            1,
                            2,
                            null,
                        ],
                        [
                            1,
                            null,
                        ],
                    ],
                    null,
                ],
                'callable' => self::callableKeyFunction(...),
                'mode' => FilterModeEnum::UseKey,
                'preserveKeys' => false,
                'expected' => [
                    [
                        [
                            null,
                        ],
                    ],
                    null,
                ],
            ],
            'callable_key_value' => [
                'input' => [
                    1,
                    2,
                    [
                        1,
                        [
                            1,
                            2,
                            null,
                        ],
                        [
                            1,
                            null,
                        ],
                    ],
                    null,
                ],
                'callable' => self::callableKeyValueFunction(...),
                'mode' => FilterModeEnum::UseKeyValue,
                'preserveKeys' => false,
                'expected' => [],
            ],
        ];
    }

    public static function callableValueFunction(mixed $v): bool
    {
        return $v === null;
    }

    public static function callableKeyFunction(string|int $k): bool
    {
        return $k > 1;
    }

    public static function callableKeyValueFunction(string|int $k, mixed $v): bool
    {
        return $k > 1 && $v !== null;
    }
}
